<?php

namespace Fitbase\Bundle\UserBundle\Event;


use Fitbase\Bundle\UserBundle\Entity\UserMedimouse;
use Symfony\Component\EventDispatcher\Event;

class UserMedimouseEvent extends Event
{
    protected $entity;

    public function __construct(UserMedimouse $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Fitbase\Bundle\UserBundle\Entity\UserMedimouse
     */
    public function getEntity()
    {
        return $this->entity;
    }

}