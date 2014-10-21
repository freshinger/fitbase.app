<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/29/14
 * Time: 2:11 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Event;


use Fitbase\Bundle\StatisticBundle\Entity\UserStatistic;
use Symfony\Component\EventDispatcher\Event;

class UserStatisticEvent extends Event
{
    protected $entity;

    public function __construct(UserStatistic $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}