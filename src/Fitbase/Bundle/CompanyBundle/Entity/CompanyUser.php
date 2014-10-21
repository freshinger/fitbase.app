<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/4/14
 * Time: 3:06 PM
 */

namespace Fitbase\Bundle\CompanyBundle\Entity;


class CompanyUser
{
    protected $user;
    protected $company;

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

}