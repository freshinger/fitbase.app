<?php

namespace Fitbase\Bundle\CompanyBundle\Listener;

use Fitbase\Bundle\CompanyBundle\Event\CompanyEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class CompanyUserListener extends ContainerAware
{
    /**
     * Set company for new imported user
     * @param \Fitbase\Bundle\UserBundle\Event\UserImportEvent $event
     */
    public function onUserImportedEvent(\Fitbase\Bundle\UserBundle\Event\UserImportEvent $event)
    {
        assert(is_object(($userImport = $event->getEntity())));

        $logger = $this->container->get('logger');
        if (($company = $userImport->getCompany())) {

            $logger->info('User import, try to find user', array($userImport->getId()));
            $managerUser = $this->container->get('fitbase_manager.user');
            if (($user = $managerUser->find($userImport->getId()))) {

                $logger->info('User import, try to find user meta', array($userImport->getId()));
                $managerUserMeta = $this->container->get('fitbase_manager.user_meta');
                $userMeta = $managerUserMeta->findOneByUserAndKey($user, 'user_company_id');

                if (!$userMeta instanceof \Ekino\WordpressBundle\Entity\UserMeta) {
                    $userMeta = new \Ekino\WordpressBundle\Entity\UserMeta();
                    $userMeta->setKey('user_company_id');
                    $userMeta->setUser($user);
                }

                $logger->info('User import, save company', array($company->getId()));
                $userMeta->setValue($company->getId());
                $managerUserMeta->save($userMeta);
            }
        }
    }

    /**
     * Create new company action
     * @param CompanyEvent $event
     */
    public function onCompanyUserUpdate(CompanyEvent $event)
    {
        assert(($companyUser = $event->getEntity()), 'Company can not be empty');
        assert(($user = $companyUser->getUser()), 'Company can not be empty');

        $this->container->get('logger')
            ->info('Company, update user', array(
                (string)$user,
            ));

        $managerUser = $this->container->get('fitbase_manager.user');
        if (($company = $companyUser->getCompany())) {
            $managerUser->saveUserMeta($companyUser->getUser(), 'user_company_id', $company->getId());
            $this->container->get('logger')
                ->info('Company, new user company', array(
                    (string)$user,
                    (string)$company,
                ));
        } else {
            $managerUser->removeUserMeta($companyUser->getUser(), 'user_company_id');
            $this->container->get('logger')
                ->info('Company, remove user company', array(
                    (string)$user,
                ));
        }

    }
}