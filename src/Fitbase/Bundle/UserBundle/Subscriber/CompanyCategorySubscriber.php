<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompanyCategorySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.company_category_create' => array('onCompanyCategoryCreateEvent'),
            'fitbase.company_category_remove' => array('onCompanyCategoryRemoveEvent'),
        );
    }

    /**
     * @param Event $event
     */
    public function onCompanyCategoryCreateEvent(Event $event)
    {

    }

    /**
     * @param Event $event
     */
    public function onCompanyCategoryRemoveEvent(Event $event)
    {

    }
}