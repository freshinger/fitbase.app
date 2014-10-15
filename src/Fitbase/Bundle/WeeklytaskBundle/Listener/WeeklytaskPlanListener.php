<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklytaskPlanListener extends ContainerAware
{
    /**
     * Process date time sent event
     * @param WeeklytaskPlanEvent $event
     */
    public function onWeeklytaskPlanSentEvent(WeeklytaskPlanEvent $event)
    {
        assert(($weeklytaskPlan = $event->getEntity()));

        $serviceDateTime = $this->container->get('datetime');

        $weeklytaskPlan->setProcessed(true);
        $weeklytaskPlan->setProcessedDate($serviceDateTime->getDateTime('now'));

        $this->container->get('fitbase_entity_manager')->persist($weeklytaskPlan);
        $this->container->get('fitbase_entity_manager')->flush($weeklytaskPlan);
    }

    /**
     * Create weekly task plan on associate weekly task with user
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserCreatedEvent(WeeklytaskUserEvent $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $managerUser = $this->container->get('fitbase_manager.user');
        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        if (($weeklytask = $repositoryWeeklytask->findOneByWeekId($weeklytaskUser->getWeekId()))) {
            $user = $managerUser->find($weeklytaskUser->getUserId());
            $serviceWeeklytask = $this->container->get('fitbase_service.weeklytask');
            if (($dateNext = $serviceWeeklytask->getUserNextDate($user))) {
                $dateNext->setTime(4, 0, 0);

                $weeklytaskPlan = new WeeklytaskPlan();
                $weeklytaskPlan->setWeekId($weeklytaskUser->getWeekId());
                $weeklytaskPlan->setWeeklytaskId($weeklytaskUser->getWeeklytaskId());
                $weeklytaskPlan->setPostId($weeklytaskUser->getPostId());
                $weeklytaskPlan->setUserId($weeklytaskUser->getUserId());
                $weeklytaskPlan->setDate($dateNext);

                $this->container->get('fitbase_entity_manager')->persist($weeklytaskPlan);
                $this->container->get('fitbase_entity_manager')->flush($weeklytaskPlan);
            }
        }
    }
}