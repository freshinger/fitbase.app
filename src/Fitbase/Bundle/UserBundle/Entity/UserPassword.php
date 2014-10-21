<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/18/14
 * Time: 11:38 AM
 */

namespace Fitbase\Bundle\UserBundle\Entity;


class UserPassword
{
    protected $current;
    protected $password;

    /**
     * @param mixed $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}