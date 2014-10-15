<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklytaskListener extends ContainerAware
{
    /**
     * On create weekly task event
     * @param WeeklytaskEvent $event
     */
    public function onWeeklytaskCreateEvent(WeeklytaskEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

    /**
     * On remove weekly task event
     * @param WeeklytaskEvent $event
     */
    public function onWeeklytaskRemoveEvent(WeeklytaskEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->remove($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

    /**
     * On update weekly task event
     * @param WeeklytaskEvent $event
     */
    public function onWeeklytaskUpdateEvent(WeeklytaskEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

}