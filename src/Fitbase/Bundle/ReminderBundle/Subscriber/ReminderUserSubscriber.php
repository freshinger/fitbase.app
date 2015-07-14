<?php

namespace Fitbase\Bundle\ReminderBundle\Subscriber;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReminderUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.reminder_user_pause_disable' => ['onReminderUserPauseDisableEvent']
        ];
    }

    /**
     * Remove user pause
     * @param ReminderUserEvent $event
     */
    public function onReminderUserPauseDisableEvent(ReminderUserEvent $event)
    {
        if (!($reminderUser = $event->getEntity())) {
            throw new \LogicException('Reminder user object not found');
        }

        $reminderUser->setPause(false);
        $reminderUser->setPauseStart(null);

        $this->container->get('entity_manager')->persist($reminderUser);
        $this->container->get('entity_manager')->flush($reminderUser);
    }
}