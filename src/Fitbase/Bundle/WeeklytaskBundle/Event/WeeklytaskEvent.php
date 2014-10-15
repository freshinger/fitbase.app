<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Symfony\Component\EventDispatcher\Event;

class WeeklytaskEvent extends Event
{

    protected $entity;


    public function __construct(Weeklytask $entity)
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