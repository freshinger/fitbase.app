<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer;
use Symfony\Component\EventDispatcher\Event;

class WeeklyquizUserAnswerEvent extends Event
{

    protected $entity;


    public function __construct(WeeklyquizUserAnswer $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(WeeklyquizUserAnswer $entity)
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