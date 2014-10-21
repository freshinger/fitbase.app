<?php
namespace Fitbase\Bundle\CompanyBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class CompanyEvent extends Event
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