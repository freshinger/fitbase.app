<?php
namespace Fitbase\Bundle\UserBundle\Entity;

interface UserInterface
{
    /**
     * @param mixed $email
     */
    public function setEmail($email);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param mixed $nameFirst
     */
    public function setNameFirst($nameFirst);

    /**
     * @return mixed
     */
    public function getNameFirst();

    /**
     * @param mixed $nameLast
     */
    public function setNameLast($nameLast);

    /**
     * @return mixed
     */
    public function getNameLast();
}