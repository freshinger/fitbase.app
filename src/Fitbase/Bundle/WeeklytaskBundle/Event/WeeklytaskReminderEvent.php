<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Symfony\Component\EventDispatcher\Event;

class WeeklytaskReminderEvent extends Event
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