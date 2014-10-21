<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:30 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GamificationUserPointlogListener extends ContainerAware
{
    /**
     * Store gamification point log
     * @param GamificationUserPointlogEvent $event
     */
    public function onGamificationUserPointlogCreateEvent(GamificationUserPointlogEvent $event)
    {
        assert(($GamificationUserPointlog = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($GamificationUserPointlog);
        $this->container->get('fitbase_entity_manager')->flush($GamificationUserPointlog);
    }
}