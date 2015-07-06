<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 02/06/15
 * Time: 15:33
 */

namespace Wellbeing\Bundle\ExerciseBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise;

class UserStateExerciseEvent extends Event
{
    protected $entity;

    public function __construct(UserStateExercise $entity)
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