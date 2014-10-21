<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/4/14
 * Time: 10:18 PM
 */

namespace Fitbase\Bundle\CompanyBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceCompany extends ContainerAware
{
    /**
     * Get company by user
     * @param $user
     * @return null
     */
    public function getUserCompany($user)
    {
        if (!empty($user)) {
            return $this->container->get('fitbase_manager.user')
                ->getCompany($user);
        }

        return null;
    }

    /**
     *
     * @param $company_id
     * @return null
     */
    public function getCompany($company_id)
    {
        if (!empty($company_id)) {
            return $this->container->get('fitbase_entity_manager')
                ->find('Fitbase\Bundle\CompanyBundle\Entity\Company', $company_id);
        }

        return null;
    }

} 