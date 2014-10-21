<?php

namespace Fitbase\Bundle\UserBundle\Event;


use Fitbase\Bundle\UserBundle\Entity\UserMedimouse;
use Symfony\Component\EventDispatcher\Event;

class RegisteredEvent extends Event
{
    protected $entity;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $displayName;
    protected $password;

    public function __construct($entity)
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

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

}