<?php

namespace Fitbase\Bundle\ReminderBundle\Listener;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\UserBundle\Event\RegisteredEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class UserListener extends ContainerAware
{
    /**
     * Create reminder
     * @param RegisteredEvent $event
     */
    public function onUserCreatedEvent($event)
    {
        assert(($user = $event->getEntity()));

        $logger = $this->container->get('logger');

        $logger->info('User reminder, create object', array(
            $user->getId()
        ));

        $reminder = new ReminderUser();
        $reminder->setUserId($user->getId());
        $reminder->setPause(0);
        $reminder->setPauseStart(null);
        $reminder->setSendWeeklyquiz(1);
        $reminder->setSendWeeklytask(1);

        $this->container->get('entity_manager')->persist($reminder);
        $this->container->get('entity_manager')->flush($reminder);

        $datetime = $this->container->get('datetime');

        $date = $datetime->getDateTime('now');
        $date->setTime(10, 0, 0);

        for ($i = 1; $i <= 5; $i++) {

            $item = new ReminderUserItem();
            $item->setDay($i);
            $item->setTime($date);
            $item->setUserId($user->getId());
            $item->setReminderId($reminder->getId());

            $this->container->get('entity_manager')->persist($item);
            $this->container->get('entity_manager')->flush($item);
        }


        $logger->info('User reminder, create object, done', array(
            $user->getId()
        ));
    }
}
