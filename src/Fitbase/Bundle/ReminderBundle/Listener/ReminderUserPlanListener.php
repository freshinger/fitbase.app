<?php

namespace Fitbase\Bundle\ReminderBundle\Listener;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserItemEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserPlanEvent;

class ReminderUserPlanListener extends ContainerAware
{
    /**
     * Mark reminder as processed
     * @param ReminderUserPlanEvent $event
     */
    public function onReminderUserSentEvent(ReminderUserPlanEvent $event)
    {
        assert(($plan = $event->getEntity()));

        $plan->setProcessed(true);

        $this->container->get('fitbase_entity_manager')->persist($plan);
        $this->container->get('fitbase_entity_manager')->flush($plan);
    }

    /**
     * Remove user plan on removed reminder item
     * @param ReminderUserItemEvent $event
     */
    public function onReminderUserItemRemovedEvent(ReminderUserItemEvent $event)
    {
        assert(($reminderItem = $event->getEntity()));

        $repositoryReminderPlan = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan');

        if (($reminderPlan = $repositoryReminderPlan->findOneByReminderItemAndNotProcessed($reminderItem))) {

            $this->container->get('fitbase_entity_manager')->remove($reminderPlan);
            $this->container->get('fitbase_entity_manager')->flush($reminderPlan);
        }
    }
}
