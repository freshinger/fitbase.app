<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserFocusCategorySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_focus_category_update' => array('onUserFocusCategoryUpdate')
        );
    }

    /**
     * Save updated user focus category
     * @param UserFocusCategoryEvent $event
     */
    public function onUserFocusCategoryUpdate(UserFocusCategoryEvent $event)
    {
        if (($entity = $event->getEntity())) {

            $this->container->get('entity_manager')->persist($entity);
            $this->container->get('entity_manager')->flush($entity);
        }
    }
}