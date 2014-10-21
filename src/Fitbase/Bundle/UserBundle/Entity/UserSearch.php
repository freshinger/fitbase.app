<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/30/14
 * Time: 2:13 PM
 */

namespace Fitbase\Bundle\UserBundle\Entity;


class UserSearch
{
    protected $string;
    protected $order;
    protected $by;

    /**
     * @param mixed $by
     */
    public function setBy($by)
    {
        $this->by = $by;
    }

    /**
     * @return mixed
     */
    public function getBy()
    {
        return $this->by;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    /**
     * @return mixed
     */
    public function getString()
    {
        return $this->string;
    }

} 