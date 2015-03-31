<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\CompanyBundle\Service;


interface ServiceCompanyInterface
{
    /**
     * Get focus for current user
     * @return null
     */
    public function current();
}