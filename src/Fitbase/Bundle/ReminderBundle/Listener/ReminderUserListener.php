<?php

namespace Fitbase\Bundle\ReminderBundle\Listener;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class ReminderUserListener extends ContainerAware
{
    public function onReminderUserCreateEvent(ReminderUserEvent $event)
    {
        assert(($reminder = $event->getEntity()));
        $this->container->get('entity_manager')->persist($reminder);
        $this->container->get('entity_manager')->flush($reminder);

        if (($user = $reminder->getUser())) {
            if (($datetime = $this->container->get('datetime')->getDateTime('now'))) {
                $datetime->setTime(16, 0);

                $entity1 = new ReminderUserItem();
                $entity1->setReminder($reminder);
                $entity1->setUser($user);
                $entity1->setDay(1);
                $entity1->setTime($datetime);
                $entity1->setType('exercise');
                $this->container->get('entity_manager')->persist($entity1);


                $entity2 = new ReminderUserItem();
                $entity2->setReminder($reminder);
                $entity2->setUser($user);
                $entity2->setDay(2);
                $entity2->setTime($datetime);
                $entity2->setType('exercise');
                $this->container->get('entity_manager')->persist($entity2);

                $entity3 = new ReminderUserItem();
                $entity3->setReminder($reminder);
                $entity3->setUser($user);
                $entity3->setDay(3);
                $entity3->setTime($datetime);
                $entity3->setType('exercise');
                $this->container->get('entity_manager')->persist($entity3);

                $entity4 = new ReminderUserItem();
                $entity4->setReminder($reminder);
                $entity4->setUser($user);
                $entity4->setDay(4);
                $entity4->setTime($datetime);
                $entity4->setType('exercise');
                $this->container->get('entity_manager')->persist($entity4);

                $entity5 = new ReminderUserItem();
                $entity5->setReminder($reminder);
                $entity5->setUser($user);
                $entity5->setDay(5);
                $entity5->setTime($datetime);
                $entity5->setType('exercise');
                $this->container->get('entity_manager')->persist($entity5);
                $this->container->get('entity_manager')->flush();
            }

            if (($datetime = $this->container->get('datetime')->getDateTime('now'))) {
                $datetime->setTime(4, 0);

                $entity1 = new ReminderUserItem();
                $entity1->setReminder($reminder);
                $entity1->setUser($user);
                $entity1->setDay(1);
                $entity1->setTime($datetime);
                $entity1->setType('weeklytask');
                $this->container->get('entity_manager')->persist($entity1);


                $entity3 = new ReminderUserItem();
                $entity3->setReminder($reminder);
                $entity3->setUser($user);
                $entity3->setDay(3);
                $entity3->setTime($datetime);
                $entity3->setType('weeklytask');
                $this->container->get('entity_manager')->persist($entity3);


                $entity5 = new ReminderUserItem();
                $entity5->setReminder($reminder);
                $entity5->setUser($user);
                $entity5->setDay(5);
                $entity5->setTime($datetime);
                $entity5->setType('weeklytask');
                $this->container->get('entity_manager')->persist($entity5);
                $this->container->get('entity_manager')->flush();

            }
        }
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
