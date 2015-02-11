<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 11/02/15
 * Time: 22:39
 */

namespace Wellbeing\Bundle\ApiBundle\Model;


class UserLogin
{

    /**
     * @var string
     */
    protected $login;


    /**
     * @var string
     */
    protected $password;

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



} 