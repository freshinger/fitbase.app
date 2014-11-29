<?php

namespace Fitbase\Bundle\CompanyBundle\Listener;

use Fitbase\Bundle\CompanyBundle\Event\CompanyEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class CompanyListener extends ContainerAware
{
    /**
     * Create new company action
     * @param CompanyEvent $event
     */
    public function onCompanyCreate(CompanyEvent $event)
    {
        assert(($company = $event->getEntity()), 'Company can not be empty');

        $this->container->get('entity_manager')->persist($company);
        $this->container->get('entity_manager')->flush($company);


        $this->container->get('event_dispatcher')
            ->dispatch('fitbase_company_created', new CompanyEvent($company));
    }

    /**
     * Update current company action
     * @param CompanyEvent $event
     */
    public function onCompanyUpdate(CompanyEvent $event)
    {
        assert(($company = $event->getEntity()), 'Company can not be empty');

        $this->container->get('entity_manager')->persist($company);
        $this->container->get('entity_manager')->flush($company);

        $this->container->get('event_dispatcher')
            ->dispatch('fitbase_company_created', new CompanyEvent($company));
    }

}