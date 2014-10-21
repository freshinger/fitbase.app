<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 4:00 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Listener;


use Fitbase\Bundle\ReminderBundle\Event\ReminderUserItemEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class ReminderUserItemListener extends ContainerAware
{
    /**
     * Create new user event reminder item
     * @param ReminderUserItemEvent $event
     */
    public function onReminderUserItemCreateEvent(ReminderUserItemEvent $event)
    {
        assert(($item = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($item);
        $this->container->get('fitbase_entity_manager')->flush($item);
    }

    /**
     * Remove user event reminder item
     * @param ReminderUserItemEvent $event
     */
    public function onReminderUserItemRemoveEvent(ReminderUserItemEvent $event)
    {
        assert(($item = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->remove($item);
        $this->container->get('fitbase_entity_manager')->flush($item);
    }

} 