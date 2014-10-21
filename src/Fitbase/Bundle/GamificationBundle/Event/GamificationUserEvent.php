<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:23 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Event;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUser;
use Symfony\Component\EventDispatcher\Event;

class GamificationUserEvent extends Event
{
    protected $entity;


    public function __construct(GamificationUser $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(GamificationUser $entity)
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