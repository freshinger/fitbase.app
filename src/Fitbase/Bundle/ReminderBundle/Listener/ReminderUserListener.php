<?php

namespace Fitbase\Bundle\ReminderBundle\Listener;

use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class ReminderUserListener extends ContainerAware
{
    public function onReminderUserCreateEvent(ReminderUserEvent $event)
    {
        assert(($reminder = $event->getEntity()));

        $this->container->get('entity_manager')->persist($reminder);
        $this->container->get('entity_manager')->flush($reminder);
    }

    /**
     * Update user reminder
     * @param ReminderUserEvent $event
     */
    public function onReminderUserUpdateEvent(ReminderUserEvent $event)
    {
        assert(($reminder = $event->getEntity()));

        $this->container->get('entity_manager')->persist($reminder);
        $this->container->get('entity_manager')->flush($reminder);
    }

    /**
     * Set user pause
     * @param ReminderUserEvent $event
     */
    public function onReminderUserPauseStartEvent(ReminderUserEvent $event)
    {
        assert(($reminder = $event->getEntity()));

        $dateTime = $this->container->get('datetime');

        $reminder->setPauseStart($dateTime->getDateTime('now'));

        $this->container->get('entity_manager')->persist($reminder);
        $this->container->get('entity_manager')->flush($reminder);
    }

    /**
     * Stop user reminder pause
     * @param ReminderUserEvent $event
     */
    public function onReminderUserPauseStopEvent(ReminderUserEvent $event)
    {
        assert(($reminder = $event->getEntity()));

        $reminder->setPause(null);
        $reminder->setPauseStart(null);

        $this->container->get('entity_manager')->persist($reminder);
        $this->container->get('entity_manager')->flush($reminder);
    }

    /**
     * Check for expiration date and expire if needs
     * @param ReminderUserEvent $event
     */
    public function onReminderUserPauseExpireEvent(ReminderUserEvent $event)
    {
        assert(($reminder = $event->getEntity()));

        $logger = $this->container->get('logger');
        $serviceDateTime = $this->container->get('datetime');

        $currentDate = $serviceDateTime->getDateTime('now');

        $endDate = $serviceDateTime->getDateTime($reminder->getPauseStart());
        $endDate->modify("+{$reminder->getPause()} week");

        if ($currentDate >= $endDate) {

            $logger->info('Pause expire task, expired', array($reminder->getId()));

            $event = new ReminderUserEvent($reminder);
            $this->container->get('event_dispatcher')
                ->dispatch('reminder_stop_pause', $event);

            return;
        }

        $logger->info('Pause expire task, not expired', array($reminder->getId()));
    }

    /**
     * Planner method for single user
     * @param ReminderUserEvent $event
     * @return bool
     */
    public function onReminderUserPlanner(ReminderUserEvent $event)
    {
//        assert(($reminder = $event->getEntity()));
//
//        $logger = $this->container->get('logger');
//        $dateTime = $this->container->get('datetime');
//        $userManager = $this->container->get('user');
//        $entityManager = $this->container->get('entity_manager');
//
//        $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
//        $repositoryReminderPlan = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan');
//
//        if (($user = $userManager->find($reminder->getUserId()))) {
//
//            $date = $dateTime->getDateTime('now');
//
//            if (($collection = $repositoryReminderItem->findAllByReminderAndDay($reminder, $date->format('N')))) {
//
//                $logger->info('Reminder planner task, reminders', array(
//                    count($collection)
//                ));
//
//                foreach ($collection as $reminderItem) {
//
//                    $reminderPlan = $repositoryReminderPlan->findOneByUserAndReminderAndDate(
//                        $user, $reminder, $reminderItem->getTime());
//
//                    if (empty($reminderPlan)) {
//
//                        $logger->info('Reminder planner task, existed plan not found', array(
//                            $reminder->getId()
//                        ));
//
//                        $plan = new ReminderPlan();
//                        $plan->setDate($reminderItem->getTime());
//                        $plan->setUserId($reminder->getUserId());
//                        $plan->setReminderId($reminder->getId());
//                        $plan->setReminderItemId($reminderItem->getId());
//                        $plan->setProcessed(false);
//
//                        $entityManager->persist($plan);
//                        $entityManager->flush($plan);
//
//                        continue;
//                    }
//
//                    $logger->info('Reminder planner task, existed plan found', array(
//                        $reminder->getId(),
//                        $reminderPlan->getId(),
//                        $reminderItem->getTime()->format('Y-m-d H:i:s')
//                    ));
//                }
//            }
//        }
    }
}
