<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'weeklytask_user_done_last' => array('onWeeklytaskUserDoneLastEvent', -128),
        );
    }

    /**
     * Check for last weeklytask that was done and try to
     * do some actions, like mark user account as expired
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserDoneLastEvent(\Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent $event)
    {
        if (($entity = $event->getEntity()) and ($user = $entity->getUser())) {
            if (($actioncode = $user->getActioncode()) and $actioncode->getExpire()) {

                $date = $this->container->get('datetime')->getDateTime('now');
                // Check a difference between last weeklytask
                // and current date, if that bigger than one week
                // expire a user account
                if (($interval = $date->diff($entity->getDate())) and ((int)$interval->format('%a')) >= 7) {
                    
                    $user->setExpired(true);

                    $this->container->get('entity_manager')->persist($user);
                    $this->container->get('entity_manager')->flush($user);
                }
            }
        }
    }
}