<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklytaskUserListener extends ContainerAware
{
    /**
     * On create weekly task event
     * @param UserEvent $event
     */
    public function onWeeklytaskUserPlanEvent(UserEvent $event)
    {
        assert(($user = $event->getEntity()));

        $logger = $this->container->get('logger');
        $entityManager = $this->container->get('fitbase_entity_manager');
        $serviceDateTime = $this->container->get('datetime');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
        $repositoryWeeklytaskPlan = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan');

        $weekId = 1;
        // Try to find last processed task and
        // increment week number from this task
        if (($weeklytaskPlan = $repositoryWeeklytaskPlan->findOneLastByProcessedAndUser($user))) {
            $weekId = $weeklytaskPlan->getWeekId() + 1;
        }

        $logger->info('Weekly task, plan for week', array($weekId, $user->getId()));

        // Check for already planned weekly task
        // and not processed for next week
        if (($weeklytaskPlanExisted = $repositoryWeeklytaskPlan->findOneByUserAndWeekId($user, $weekId))) {
            $logger->info('Weekly task, plan found', array($weeklytaskPlanExisted->getId()));
            return;
        }

        // Get weekly task from database
        // if not exists, we have not to do something
        if (!($weeklytask = $repositoryWeeklytask->findOneByWeekId($weekId))) {
            $logger->info('Weekly task, weeklyt task not found', array($weekId));
            return;
        }

        $weeklytaskUser = new WeeklytaskUser();
        $weeklytaskUser->setUserId($user->getId());
        $weeklytaskUser->setWeekId($weekId);
        $weeklytaskUser->setPostId($weeklytask->getPostId());
        $weeklytaskUser->setWeeklytaskId($weeklytask->getId());
        $weeklytaskUser->setCode($this->container->get('codegenerator')->code(20));
        $weeklytaskUser->setCountPoint($weeklytask->getCountPoint());
        $weeklytaskUser->setDone(false);

        $this->container->get('event_dispatcher')
            ->dispatch('weeklytask_user_create',
                new WeeklytaskUserEvent($weeklytaskUser));

        $this->container->get('event_dispatcher')
            ->dispatch('weeklytask_user_created',
                new WeeklytaskUserEvent($weeklytaskUser));
    }

    /**
     * Process request to send event
     * @param UserEvent $event
     */
    public function onWeeklytaskUserSendEvent(UserEvent $event)
    {
        assert(($user = $event->getEntity()));

        $logger = $this->container->get('logger');
        $repositoryWeeklytaskPlan = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan');

        $serviceDateTime = $this->container->get('datetime');

        $logger->info('Weekly task, sender date', array($serviceDateTime->getDateTime('now')->format('Y-m-d H:i:s')));

        if (($collection = $repositoryWeeklytaskPlan->findAllByUserAndDateAndNotProcessed($user, $serviceDateTime->getDateTime('now')))) {

            foreach ($collection as $weeklytaskPlan) {

                $logger->info('Weekly task, plan found', array($weeklytaskPlan->getDate()->format('Y-m-d H:i:s')));

                $weeklytaskPlanEvent = new WeeklytaskPlanEvent($weeklytaskPlan);
                $this->container->get('event_dispatcher')
                    ->dispatch('weeklytask_plan_send', $weeklytaskPlanEvent);
            }
        }
    }

    /**
     * On weekly task create event
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserCreateEvent(WeeklytaskUserEvent $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $repositoryWeeklytaskUser = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

        if (!($weeklytaskUserExist = $repositoryWeeklytaskUser->findOneByWeeklytaskUser($weeklytaskUser))) {

            $this->container->get('fitbase_entity_manager')->persist($weeklytaskUser);
            $this->container->get('fitbase_entity_manager')->flush($weeklytaskUser);
        }
    }

    /**
     * Mark weekly task as completed
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserDoneEvent(WeeklytaskUserEvent $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $logger = $this->container->get('logger');
        $logger->info('Weekly task, done event', array($weeklytaskUser->getId()));

        $serviceDateTime = $this->container->get('datetime');

        $weeklytaskUser->setDone(true);
        $weeklytaskUser->setDoneDate($serviceDateTime->getDateTime());

        $this->container->get('fitbase_entity_manager')->persist($weeklytaskUser);
        $this->container->get('fitbase_entity_manager')->flush($weeklytaskUser);
    }

}