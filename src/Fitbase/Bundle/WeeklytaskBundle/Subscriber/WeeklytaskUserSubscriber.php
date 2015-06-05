<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskUserSubscriber implements EventSubscriberInterface
{
    protected $objectManager;
    protected $datetime;
    protected $eventDispatcher;
    protected $weeklytask;

    public function __construct($objectManager, $eventDispatcher, $datetime, $weeklytask)
    {
        $this->objectManager = $objectManager;
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
            'fitbase.weeklytask_user_done' => array('onWeeklytaskUserDoneEvent'),
        );
    }

    /**
     * Mark weekly task as completed
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserDoneEvent(WeeklytaskUserEvent $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $weeklytaskUser->setDone(true);
        $weeklytaskUser->setDoneDate($this->datetime->getDateTime('now'));
        $weeklytaskUser->setCountPoint(0);

        if (($weeklytask = $weeklytaskUser->getTask())) {
            $weeklytaskUser->setCountPoint($weeklytask->getCountPoint());
        }

        $this->objectManager->persist($weeklytaskUser);
        $this->objectManager->flush($weeklytaskUser);
    }
}