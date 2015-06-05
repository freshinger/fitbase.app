<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 10:55
 */

namespace Fitbase\Bundle\ExerciseBundle\Event;


use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Symfony\Component\EventDispatcher\Event;

class ExerciseEvent extends Event
{
    protected $entity;

    public function __construct(Exercise $entity = null)
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

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }
}