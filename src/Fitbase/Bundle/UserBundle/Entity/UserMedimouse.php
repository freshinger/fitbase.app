<?php

namespace Fitbase\Bundle\UserBundle\Entity;

class UserMedimouse implements UserInterface
{
    protected $id;
    protected $nameFirst;
    protected $nameLast;
    protected $email;
    protected $login;
    protected $password;
    protected $displayName;
    protected $registered;
    protected $bereich;
    protected $type;
    protected $extra;
    protected $role;

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
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
     * @param mixed $registered
     */
    public function setRegistered($registered)
    {
        $this->registered = $registered;
    }

    /**
     * @return mixed
     */
    public function getRegistered()
    {
        return $this->registered;
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

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $bereich
     */
    public function setBereich($bereich)
    {
        $this->bereich = $bereich;
    }

    /**
     * @return mixed
     */
    public function getBereich()
    {
        return $this->bereich;
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
     * @param mixed $extra
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param mixed $nameFirst
     */
    public function setNameFirst($nameFirst)
    {
        $this->nameFirst = $nameFirst;
    }

    /**
     * @return mixed
     */
    public function getNameFirst()
    {
        return $this->nameFirst;
    }

    /**
     * @param mixed $nameLast
     */
    public function setNameLast($nameLast)
    {
        $this->nameLast = $nameLast;
    }

    /**
     * @return mixed
     */
    public function getNameLast()
    {
        return $this->nameLast;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }


}