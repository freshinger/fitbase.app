<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Event;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Symfony\Component\EventDispatcher\Event;

class WeeklytaskUserEvent extends Event
{

    protected $entity;


    public function __construct(WeeklytaskUser $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(WeeklytaskUser $entity)
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