<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 10:59 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


class QuestionnaireSearch
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