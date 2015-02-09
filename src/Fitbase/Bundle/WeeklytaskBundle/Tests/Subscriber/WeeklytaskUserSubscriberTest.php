<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 09/02/15
 * Time: 10:20
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Test\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Subscriber\WeeklytaskUserSubscriber;

class WeeklytaskUserSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $datetime;
    protected $eventDispatcher;
    protected $weeklytask;

    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

        $this->datetime = $this->getMock('DateTime', array('getDateTime'));
        $this->datetime->expects($this->any())
            ->method('getDateTime')
            ->will($this->returnValue(new \DateTime('now')));

        $this->eventDispatcher = $this->getMock('EventDispatcher', array('dispatch'));

        $this->weeklytask = $this->getMock('Weeklytask', array('isExists', 'create', 'isLast', 'getLast'));
        $this->weeklytask->expects($this->any())
            ->method('isExists')
            ->will($this->returnValue(false));
        $this->weeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnValue(true));

        $this->weeklytask->expects($this->any())
            ->method('getLast')
            ->will($this->returnValue(new WeeklytaskUser()));
    }

    /**
     * Check that method create a plan
     * for user
     */
    public function testMethod_onWeeklytaskReminderCreateEvent_shouldCreatePlan()
    {

        $processedUser = null;
        $processedDatetime = null;

        $this->weeklytask->expects($this->any())
            ->method('isLast')
            ->will($this->returnValue(true));

        $this->weeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function ($user, $datetime) use (&$processedUser, &$processedDatetime) {
                $processedUser = $user;
                $processedDatetime = $datetime;
            }));


        $event = new WeeklytaskReminderEvent(
            (new ReminderUserItem())
                ->setUser(
                    (new User())
                )
                ->setTime(new \DateTime('now'))
        );

        (new WeeklytaskUserSubscriber($this->eventDispatcher, $this->datetime, $this->weeklytask))
            ->onWeeklytaskReminderCreateEvent($event);

        $this->assertTrue($processedUser instanceof User);
        $this->assertTrue($processedDatetime instanceof \DateTime);
    }

    /**
     * Check is infoeinheit not last
     * does not send a last-infoeinheit-event
     *
     */
    public function testMethod_onWeeklytaskReminderCreateEvent_shouldNotCreateLastEvent()
    {
        $processedCode = null;
        $processedEvent = null;

        $this->weeklytask->expects($this->any())
            ->method('isLast')
            ->will($this->returnValue(false));

        $this->weeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnValue(true));

        $this->eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnCallback(function ($code, $event) use (&$processedCode, &$processedEvent) {
                $processedCode = $code;
                $processedEvent = $event;
            }));


        $event = new WeeklytaskReminderEvent(
            (new ReminderUserItem())
                ->setUser(
                    (new User())
                )
                ->setTime(new \DateTime('now'))
        );

        (new WeeklytaskUserSubscriber($this->eventDispatcher, $this->datetime, $this->weeklytask))
            ->onWeeklytaskReminderCreateEvent($event);


        $this->assertEquals($processedCode, null);
        $this->assertEquals($processedEvent, null);
    }

    /**
     * Check is system create event for
     * last weeklytask
     *
     */
    public function testMethod_onWeeklytaskReminderCreateEvent_shouldCreateLastWeeklytaskEvent()
    {
        $processedCode = null;
        $processedEvent = null;

        $this->weeklytask->expects($this->any())
            ->method('isLast')
            ->will($this->returnValue(true));

        $this->eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnCallback(function ($code, $event) use (&$processedCode, &$processedEvent) {
                $processedCode = $code;
                $processedEvent = $event;
            }));


        $event = new WeeklytaskReminderEvent(
            (new ReminderUserItem())
                ->setUser(
                    (new User())
                )
                ->setTime(new \DateTime('now'))
        );

        (new WeeklytaskUserSubscriber($this->eventDispatcher, $this->datetime, $this->weeklytask))
            ->onWeeklytaskReminderCreateEvent($event);


        $this->assertEquals($processedCode, 'weeklytask_user_done_last');
        $this->assertTrue($processedEvent instanceof WeeklytaskUserEvent);
    }
}