<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/9/14
 * Time: 3:13 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Event;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan;
use Symfony\Component\EventDispatcher\Event;

class ReminderPlanEvent extends Event
{

    protected $entity;

    public function __construct(ReminderPlan $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param \Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan
     */
    public function getEntity()
    {
        return $this->entity;
    }

} 