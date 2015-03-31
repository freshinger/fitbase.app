<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\CompanyBundle\Service;


class ServiceCompany implements ServiceCompanyInterface
{
    protected $serviceUser;

    /**
     * Class constructor
     * @param $serviceUser
     */
    public function __construct($serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    /**
     * Get focus for current user
     * @return null
     */
    public function current()
    {
        if (($user = $this->serviceUser->current())) {
            return $user->getCompany();
        }
        return null;
    }
}