<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/06/15
 * Time: 10:59
 */

namespace Fitbase\Bundle\FitbaseBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class AuthenticateTokenEvent extends Event
{
    protected $token;
    protected $userProvider;
    protected $providerKey;

    public function __construct($token, $userProvider, $providerKey)
    {
        $this->token = $token;
        $this->userProvider = $userProvider;
        $this->providerKey = $providerKey;
    }

    /**
     * @return mixed
     */
    public function getProviderKey()
    {
        return $this->providerKey;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getUserProvider()
    {
        return $this->userProvider;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
}