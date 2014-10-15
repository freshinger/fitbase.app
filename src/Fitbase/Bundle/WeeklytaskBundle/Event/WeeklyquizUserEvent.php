<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Symfony\Component\EventDispatcher\Event;

class WeeklyquizUserEvent extends Event
{
    protected $entity;


    public function __construct(WeeklyquizUser $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(WeeklyquizUser $entity)
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