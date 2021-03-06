<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/23/14
 * Time: 10:51 AM
 */

namespace Fitbase\Bundle\StatisticBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class UserStatisticExerciseEvent extends Event
{

    protected $entity;

    public function __construct($entity)
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