<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan;
use Symfony\Component\EventDispatcher\Event;

class WeeklytaskPlanEvent extends Event
{

    protected $entity;


    public function __construct(WeeklytaskPlan $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(Weeklytask $entity)
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