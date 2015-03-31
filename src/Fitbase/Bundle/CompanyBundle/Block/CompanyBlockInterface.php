<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;

use Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface;

interface CompanyBlockInterface
{
    /**
     * Set service company
     * @param ServiceCompanyInterface $serviceCompany
     * @return $this
     */
    public function setServiceCompany(ServiceCompanyInterface $serviceCompany);
}