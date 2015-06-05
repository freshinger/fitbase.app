<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 02/06/15
 * Time: 15:33
 */

namespace Wellbeing\Bundle\ErgonomicsBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics;

class UserStateErgonomicsEvent extends Event
{
    protected $entity;

    public function __construct(UserStateErgonomics $entity)
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