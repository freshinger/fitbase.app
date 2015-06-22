<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Subscriber;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Subscriber\WeeklytaskUserSubscriber;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;

class UserBundleWeeklytaskUserSubscriberTest extends FitbaseTestAbstract
{

    /**
     * Get weeklytaks object for current test
     *
     * @return Weeklytask
     */
    protected function getWeeklytask()
    {
        return (new Weeklytask());
    }

    /**
     * Get weeklytask user object for current test
     *
     * @return WeeklytaskUser
     */
    protected function getWeeklytaskUser()
    {
        return (new WeeklytaskUser())
            ->setUser(
                (new User())
                    ->setActioncode(
                        (new UserActioncode())
                            ->setExpire(true)
                    )
            );
    }

    /**
     * Get datetime service for current test
     *
     * @return object
     */
    protected function getServiceDateTime()
    {

        return $this->container()->get('datetime');
    }

    /**
     * Get weeklytask service for current test
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getServiceWeeklytask()
    {
        $serviceWeeklytask = $this->getMock('ServiceWeeklytask', ['last']);


        return $serviceWeeklytask;
    }

    /**
     * Get entity manager service for current test
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getServiceEntityManager()
    {
        $entityManager = $this->getEntityManager();


        return $entityManager;
    }

    public function testOnWeeklytaskReminderLastEventShouldThrowException()
    {
        $datetime = $this->getServiceDateTime();
        $entityManager = $this->getServiceEntityManager();
        $weeklytask = $this->getServiceWeeklytask();

        $exception = null;

        try {

            (new WeeklytaskUserSubscriber($datetime, $weeklytask, $entityManager))
                ->onWeeklytaskReminderLastEvent(new WeeklytaskUserEvent($this->getWeeklytaskUser()));
        } catch (\LogicException $exception) {

        }

        $this->assertNotEmpty($exception->getMessage());
    }

    public function testOnWeeklytaskReminderLastEventShouldNotExpireUser()
    {
        $datetime = $this->getServiceDateTime();
        $entityManager = $this->getServiceEntityManager();
        $weeklytask = $this->getServiceWeeklytask();
        $weeklytask->expects($this->any())
            ->method('last')->will($this->returnCallback(function ($user) use ($datetime) {
                $weeklytaskUser = $this->getWeeklytaskUser();
                $weeklytaskUser->setDate($datetime->getDateTime('now'));
                return $weeklytaskUser;
            }));


        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());

        (new WeeklytaskUserSubscriber($datetime, $weeklytask, $entityManager))
            ->onWeeklytaskReminderLastEvent($event);

        $this->assertFalse($event->getEntity()->getUser()->isExpired());
    }

    public function testOnWeeklytaskReminderLastEventShouldExpireUser()
    {
        $datetime = $this->getServiceDateTime();
        $entityManager = $this->getServiceEntityManager();
        $weeklytask = $this->getServiceWeeklytask();
        $weeklytask->expects($this->any())
            ->method('last')->will($this->returnCallback(function ($user) use ($datetime) {
                $weeklytaskUser = $this->getWeeklytaskUser();
                $weeklytaskUser->setDate($datetime->getDateTime('now')->modify('-7 days'));
                return $weeklytaskUser;
            }));


        $event = new WeeklytaskUserEvent($this->getWeeklytaskUser());

        (new WeeklytaskUserSubscriber($datetime, $weeklytask, $entityManager))
            ->onWeeklytaskReminderLastEvent($event);

        $this->assertTrue($event->getEntity()->getUser()->isExpired());
    }

}