<?php

namespace Fitbase\Bundle\CompanyBundle\Subscriber;

use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\ExerciseBundle\Event\CategoryEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompanyCategorySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array();
    }
}