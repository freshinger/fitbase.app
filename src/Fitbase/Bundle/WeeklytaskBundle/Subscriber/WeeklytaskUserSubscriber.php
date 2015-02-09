<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskUserSubscriber implements EventSubscriberInterface
{
    protected $datetime;
    protected $eventDispatcher;
    protected $weeklytask;

    public function __construct($eventDispatcher, $datetime, $weeklytask)
    {
        $this->datetime = $datetime;
        $this->eventDispatcher = $eventDispatcher;
        $this->weeklytask = $weeklytask;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'weeklytask_reminder_create' => array('onWeeklytaskReminderCreateEvent'),
        );
    }

    /**
     * Create weeklytask reminder
     * @param WeeklytaskReminderEvent $event
     */
    public function onWeeklytaskReminderCreateEvent(WeeklytaskReminderEvent $event)
    {
        if (($reminderUserItem = $event->getEntity())) {
            if (($user = $reminderUserItem->getUser())) {


                $hour = $reminderUserItem->getTime()->format('H');
                $minute = $reminderUserItem->getTime()->format('i');


                $datetime = $this->datetime->getDateTime('now');
                $datetime->setTime($hour, $minute);

                // Check is weeklytask for this date
                // already exists break up a scenario
                if (!$this->weeklytask->isExists($user, $datetime)) {
                    // Try to create a new weeklytask for this user
                    // and this date, if task has been created,
                    // break up a scenario
                    $this->weeklytask->create($user, $datetime);
                }

                // Check is a last weeklytask was already sent
                // for current user, than create a event that
                // a last weeklytask was sent
                if ($this->weeklytask->isLast($user, $datetime)) {
                    if (($weeklytaskUser = $this->weeklytask->getLast($user))) {

                        $event = new WeeklytaskUserEvent($weeklytaskUser);
                        $this->eventDispatcher->dispatch('weeklytask_user_done_last', $event);
                    }
                }

            }
        }
    }


}