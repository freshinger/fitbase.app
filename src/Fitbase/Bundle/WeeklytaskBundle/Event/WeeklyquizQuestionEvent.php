<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion;
use Symfony\Component\EventDispatcher\Event;

class WeeklyquizQuestionEvent extends Event
{
    protected $entity;

    public function __construct(WeeklyquizQuestion $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(WeeklyquizQuestion $entity)
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