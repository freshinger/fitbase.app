<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 11:16
 */

namespace Wellbeing\Bundle\ApiBundle\Model;


class UserAuth
{
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

        return $this;
    }
}