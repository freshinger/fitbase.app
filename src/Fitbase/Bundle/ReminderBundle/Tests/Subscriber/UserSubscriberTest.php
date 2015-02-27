<?php

namespace Fitbase\Bundle\ReminderBundle\Tests\Subscriber;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserSubscriberTest extends WebTestCase
{
    protected $datetime;
    protected $objectManager;

    public function setUp()
    {
        $this->datetime = $this->getMock('Datetime', array('getDateTime'));
        $this->datetime->expects($this->any())->method('getDateTime')
            ->will($this->returnValue(new \DateTime('now')));

        $this->objectManager = $this->getMock('EntityManager', array('persist', 'flush'));
    }


    public function testSubscriberShouldCreateUserReminderObject()
    {
        $userReminder = null;

        $this->objectManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$userReminder) {
                if ($userReminder == null) {
                    $userReminder = $entity;
                }
            }));


        (new UserSubscriber($this->objectManager, $this->datetime))
            ->onUserRegisteredEvent(new UserEvent(
                (new User())
            ));

        $this->assertTrue($userReminder instanceof ReminderUser);
    }


    public function testSubscriberShouldCreateUserReminderItemObjects()
    {
        $userReminderItems = array();

        $this->objectManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$userReminderItems) {
                if (!$entity instanceof ReminderUser) {
                    array_push($userReminderItems, $entity);
                }
            }));


        (new UserSubscriber($this->objectManager, $this->datetime))
            ->onUserRegisteredEvent(new UserEvent(
                (new User())
            ));

        $this->assertEquals(count($userReminderItems), 6);
    }
} 