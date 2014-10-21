<?php

namespace Fitbase\Bundle\UserBundle\Event;


use Fitbase\Bundle\UserBundle\Entity\UserImport;
use Symfony\Component\EventDispatcher\Event;

class UserImportEvent extends Event
{
    protected $entity;

    public function __construct(UserImport $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Fitbase\Bundle\UserBundle\Entity\UserImport
     */
    public function getEntity()
    {
        return $this->entity;
    }

}