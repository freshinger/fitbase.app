<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_registered' => array('onUserRegisteredEvent'),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserRegisteredEvent(UserEvent $event)
    {
        if (($user = $event->getEntity())) {

        }
    }
}