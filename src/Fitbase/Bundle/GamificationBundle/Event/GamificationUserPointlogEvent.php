<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:23 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Event;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog;
use Symfony\Component\EventDispatcher\Event;

class GamificationUserPointlogEvent extends Event
{
    protected $entity;


    public function __construct(GamificationUserPointlog $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(GamificationUserPointlog $entity)
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