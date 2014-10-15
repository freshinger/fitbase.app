<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Symfony\Component\EventDispatcher\Event;

class WeeklyquizEvent extends Event
{

    protected $entity;


    public function __construct(Weeklyquiz $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(Weeklyquiz $entity)
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