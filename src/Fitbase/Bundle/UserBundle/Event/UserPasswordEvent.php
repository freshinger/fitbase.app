<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/25/14
 * Time: 1:49 PM
 */

namespace Fitbase\Bundle\UserBundle\Event;


use Fitbase\Bundle\UserBundle\Entity\UserPassword;
use Symfony\Component\EventDispatcher\Event;

class UserPasswordEvent extends Event
{

    protected $entity;

    public function __construct(UserPassword $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param \Symfony\Component\Security\Core\Validator\Constraints\UserPassword $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Symfony\Component\Security\Core\Validator\Constraints\UserPassword
     */
    public function getEntity()
    {
        return $this->entity;
    }

} 