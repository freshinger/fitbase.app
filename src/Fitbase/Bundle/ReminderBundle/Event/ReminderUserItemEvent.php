<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 3:55 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Event;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Symfony\Component\EventDispatcher\Event;

class ReminderUserItemEvent extends Event
{
    protected $entity;

    public function __construct(ReminderUserItem $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param \Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem
     */
    public function getEntity()
    {
        return $this->entity;
    }
} 