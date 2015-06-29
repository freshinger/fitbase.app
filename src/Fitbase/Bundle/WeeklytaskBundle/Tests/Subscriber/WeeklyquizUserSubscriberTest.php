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
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Subscriber\WeeklyquizUserSubscriber;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeeklyquizUserSubscriberTest extends FitbaseTestAbstract
{

    /**
     * Get weeklyquiz user object, predefined for current test
     *
     * @return WeeklyquizUser
     */
    protected function getWeeklyquizUser()
    {
        return (new WeeklyquizUser())
            ->setUser($this->getUser());
    }

    /**
     * Get user object for this test
     *
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
     * Get exercise user reminder repository
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getWeeklyquizUserRepository()
    {
        return $this->getMock('WeeklyquizUserRepository', ['exists', 'processed']);
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


    public function testOnWeeklyquizReminderProcessEventShouldThrowException()
    {
        $repository = $this->getWeeklyquizUserRepository();
        $repository->expects($this->any())
            ->method('processed')->will($this->returnValue(
                $this->getWeeklyquizUser()
            ));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $datetime = $this->container()->get('datetime');


        $exception = null;

        try {

            (new WeeklyquizUserSubscriber($datetime, $entityManager))
                ->onWeeklyquizReminderProcessEvent(
                    new WeeklyquizUserEvent($this->getWeeklyquizUser())
                );

        } catch (\Exception $exception) {

        }

        $this->assertTrue($exception instanceof \LogicException);
    }

    public function testOnWeeklyquizReminderProcessEventShouldMarkAsProcessed()
    {
        $repository = $this->getWeeklyquizUserRepository();
        $repository->expects($this->any())
            ->method('processed')->will($this->returnValue(null));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $datetime = $this->container()->get('datetime');


        $event = new WeeklyquizUserEvent($this->getWeeklyquizUser());

        (new WeeklyquizUserSubscriber($datetime, $entityManager))
            ->onWeeklyquizReminderProcessEvent($event);

        $this->assertTrue($event->getEntity()->getProcessed());
        $this->assertTrue($event->getEntity()->getProcessedDate() instanceof \DateTime);
    }

    public function onWeeklyquizReminderExceptionEventShouldMarkAsProcessed()
    {
        $repository = $this->getWeeklyquizUserRepository();
        $repository->expects($this->any())
            ->method('processed')->will($this->returnValue(null));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $datetime = $this->container()->get('datetime');


        $event = new WeeklyquizUserEvent($this->getWeeklyquizUser());

        (new WeeklyquizUserSubscriber($datetime, $entityManager))
            ->onWeeklyquizReminderExceptionEvent($event);

        $this->assertTrue($event->getEntity()->getError());
        $this->assertTrue($event->getEntity()->getErrorDate() instanceof \DateTime);
        $this->assertTrue($event->getEntity()->getProcessed());
    }

}