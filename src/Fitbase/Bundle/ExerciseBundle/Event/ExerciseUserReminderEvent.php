<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 10:55
 */

namespace Fitbase\Bundle\ExerciseBundle\Event;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;
use Symfony\Component\EventDispatcher\Event;

class ExerciseUserReminderEvent extends Event
{
    protected $entity;

    public function __construct(ExerciseUserReminder $entity)
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
    public function setEntity(ExerciseUserReminder $entity)
    {
        $this->entity = $entity;
    }

} 