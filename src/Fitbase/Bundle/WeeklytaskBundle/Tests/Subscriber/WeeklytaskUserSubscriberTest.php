<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Subscriber;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\WeeklytaskBundle\Consumer\WeeklytaskPlannerConsumer;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Subscriber\WeeklytaskUserSubscriber;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeeklytaskUserSubscriberTest extends FitbaseTestAbstract
{
    /**
     * Get user object for this test
     * @return User
     */
    protected function getUser()
    {
        return (new User())
            ->setCompany(new Company())
            ->setEmail('test@test.com')
            ->setFocus(new UserFocus());
    }

    /**
     * Get weeklyquiz user object, predefined for current test
     *
     * @return WeeklyquizUser
     */
    protected function getWeeklytaskUser()
    {
        return (new WeeklytaskUser())
            ->setDate(new \DateTime())
            ->setUser($this->getUser());
    }

    /**
     * Weeklytask service
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getWeeklytaskService()
    {
        return $this->getMock('WeeklytaskService', array('choose'));

    }

    /**
     * Codegenerator service
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getCodegeneratorService()
    {
        return $this->getMock('CodegeneratorService', array('password'));
    }

    /**
     * Get exercise user reminder repository
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getWeeklytaskUserRepository()
    {
        return $this->getMock('WeeklytaskUserRepository', array('exists', 'processed'));
    }

    /**
     * Redefine entity manager object for current test
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEntityManager()
    {
        $entityManager = parent::getEntityManager();

        $entityManager->expects($this->any())
            ->method('persist')->will($this->returnValue(true));

        $entityManager->expects($this->any())
            ->method('flush')->will($this->returnValue(true));

        return $entityManager;
    }

    public function testOnWeeklytaskReminderCreateEventShouldThrowException()
    {
        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())
            ->method('exists')->will($this->returnValue(
                $this->getWeeklytaskUser()
            ));

        $weeklytask = $this->getWeeklytaskService();
        $weeklytask->expects($this->any())
            ->method('choose')->will($this->returnValue(new Weeklytask()));

        $datetime = $this->container()->get('datetime');
        $codegenerator = $this->getCodegeneratorService();
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $flushed = null;
        $entityManager->expects($this->any())
            ->method('flush')->will($this->returnCallback(function ($entity) use (&$flushed) {
                $flushed = $entity;
            }));

        $exception = null;

        try {
            (new WeeklytaskUserSubscriber($datetime, $weeklytask, $codegenerator, $entityManager))
                ->onWeeklytaskReminderCreateEvent(
                    new WeeklytaskUserEvent($this->getWeeklytaskUser())
                );

        } catch (\Exception $exception) {

        }

        $this->assertTrue($exception instanceof \LogicException);
    }


    public function testOnWeeklytaskReminderCreateEventShouldFillTaskData()
    {
        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())
            ->method('exists')->will($this->returnValue(null));

        $weeklytask = $this->getWeeklytaskService();
        $weeklytask->expects($this->any())
            ->method('choose')->will($this->returnValue(new Weeklytask()));

        $datetime = $this->container()->get('datetime');
        $codegenerator = $this->getCodegeneratorService();
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $flushed = null;
        $entityManager->expects($this->any())
            ->method('flush')->will($this->returnCallback(function ($entity) use (&$flushed) {
                $flushed = $entity;
            }));

        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());

        (new WeeklytaskUserSubscriber($datetime, $weeklytask, $codegenerator, $entityManager))
            ->onWeeklytaskReminderCreateEvent($event);

        $this->assertEquals($event->getEntity()->getDone(), 0);
        $this->assertEquals($event->getEntity()->getError(), 0);
        $this->assertEquals($event->getEntity()->getProcessed(), 0);
        $this->assertEquals($event->getEntity()->getCountPoint(), 0);
        $this->assertTrue($event->getEntity()->getTask() instanceof Weeklytask);
        $this->assertNull($event->getEntity()->getDoneDate());
        $this->assertNull($event->getEntity()->getErrorDate());
        $this->assertTrue($flushed instanceof WeeklytaskUser);
    }

    public function testOnWeeklytaskReminderCreateEventShouldFillQuizData()
    {
        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())
            ->method('exists')->will($this->returnValue(null));

        $weeklytask = $this->getWeeklytaskService();
        $weeklytask->expects($this->any())
            ->method('choose')->will($this->returnValue(
                (new Weeklytask())
                    ->setQuiz((new Weeklyquiz()))
            ));

        $datetime = $this->container()->get('datetime');
        $codegenerator = $this->getCodegeneratorService();
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $flushed = [];
        $entityManager->expects($this->any())
            ->method('flush')->will($this->returnCallback(function ($entity) use (&$flushed) {
                array_push($flushed, $entity);
            }));

        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());

        (new WeeklytaskUserSubscriber($datetime, $weeklytask, $codegenerator, $entityManager))
            ->onWeeklytaskReminderCreateEvent($event);


        $this->assertNotEmpty(($userQuiz = $flushed[1]));

        $this->assertEquals($userQuiz->getDone(), 0);
        $this->assertNull($userQuiz->getDoneDate());
        $this->assertEquals($userQuiz->getError(), 0);
        $this->assertNull($userQuiz->getErrorDate());
        $this->assertEquals($userQuiz->getProcessed(), 0);
        $this->assertNull($userQuiz->getProcessedDate());
    }


    public function testOnWeeklytaskReminderProcessEventShouldThrowException()
    {
        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())->method('processed')
            ->will($this->returnValue(
                $this->getWeeklytaskUser()
            ));

        $datetime = $this->container()->get('datetime');
        $weeklytask = $this->getWeeklytaskService();
        $codegenerator = $this->getCodegeneratorService();
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());


        $exception = null;

        try {

            (new WeeklytaskUserSubscriber($datetime, $weeklytask, $codegenerator, $entityManager))
                ->onWeeklytaskReminderProcessEvent($event);

        } catch (\Exception $exception) {

        }

        $this->assertTrue($exception instanceof \LogicException);
    }


    public function testOnWeeklytaskReminderProcessEventShouldSetProcessedFlag()
    {
        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())->method('processed')
            ->will($this->returnValue(null));

        $datetime = $this->container()->get('datetime');
        $weeklytask = $this->getWeeklytaskService();
        $codegenerator = $this->getCodegeneratorService();
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());

        (new WeeklytaskUserSubscriber($datetime, $weeklytask, $codegenerator, $entityManager))
            ->onWeeklytaskReminderProcessEvent($event);

        $this->assertTrue($event->getEntity()->getProcessed());
        $this->assertTrue($event->getEntity()->getProcessedDate() instanceof \DateTime);
    }


    public function testOnWeeklytaskReminderExceptionEventShouldSetErrorFlag()
    {
        $datetime = $this->container()->get('datetime');
        $weeklytask = $this->getWeeklytaskService();
        $entityManager = $this->getEntityManager();
        $codegenerator = $this->getCodegeneratorService();

        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());

        (new WeeklytaskUserSubscriber($datetime, $weeklytask, $codegenerator, $entityManager))
            ->onWeeklytaskReminderExceptionEvent($event);

        $this->assertTrue($event->getEntity()->getError());
        $this->assertTrue($event->getEntity()->getErrorDate() instanceof \DateTime);
        $this->assertTrue($event->getEntity()->getProcessed());
    }


}