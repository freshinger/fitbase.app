<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 02/02/15
 * Time: 12:55
 */

namespace Wellbeing\Bundle\ApiBundle\Entity;


class UserAuthkey
{
    /**
     *
     * @var string
     */
    protected $authkey;

    /**
     * @return mixed
     */
    public function getAuthkey()
    {
        return $this->authkey;
    }

    /**
     * @param mixed $authkey
     */
    public function setAuthkey($authkey)
    {
        $this->authkey = $authkey;
    }
}