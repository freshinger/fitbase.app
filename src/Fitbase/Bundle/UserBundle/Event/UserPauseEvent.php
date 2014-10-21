<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/25/14
 * Time: 1:49 PM
 */

namespace Fitbase\Bundle\UserBundle\Event;


use Fitbase\Bundle\UserBundle\Entity\UserPause;
use Symfony\Component\EventDispatcher\Event;

class UserPauseEvent extends Event
{

    protected $entity;

    public function __construct(UserPause $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param \Symfony\Component\Security\Core\Validator\Constraints\UserPause $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Symfony\Component\Security\Core\Validator\Constraints\UserPause
     */
    public function getEntity()
    {
        return $this->entity;
    }

} 