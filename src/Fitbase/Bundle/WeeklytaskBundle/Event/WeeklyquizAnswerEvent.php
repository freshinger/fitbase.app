<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer;
use Symfony\Component\EventDispatcher\Event;

class WeeklyquizAnswerEvent extends Event
{

    protected $entity;


    public function __construct(WeeklyquizAnswer $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(WeeklyquizAnswer $entity)
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