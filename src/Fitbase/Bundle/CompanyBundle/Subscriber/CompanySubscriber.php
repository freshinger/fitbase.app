<?php

namespace Fitbase\Bundle\CompanyBundle\Subscriber;

use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\ExerciseBundle\Event\CategoryEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CompanySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelRequestEvent', 128),
        );
    }

    /**
     * Catch event from kernel
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelRequestEvent(FilterResponseEvent $event)
    {
        if (($slug = $event->getRequest()->get('company'))) {
            $event->getRequest()->getSession()->set('company', $slug);
        }
    }
}