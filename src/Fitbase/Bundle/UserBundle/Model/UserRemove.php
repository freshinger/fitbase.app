<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/04/15
 * Time: 10:28
 */
namespace Fitbase\Bundle\UserBundle\Model;

class UserRemove
{
    protected $accept;

    /**
     * @return mixed
     */
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * @param $accept
     * @return $this
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;
        return $this;
    }
}