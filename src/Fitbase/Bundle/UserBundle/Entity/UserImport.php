<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/27/14
 * Time: 10:08 AM
 */

namespace Fitbase\Bundle\UserBundle\Entity;


class UserImport implements UserInterface
{
    protected $id;
    protected $role;
    protected $email;
    protected $login;
    protected $password;
    protected $nameFirst;
    protected $nameLast;
    protected $nameDisplay;
    protected $registeredAt;
    protected $company;
    protected $text;
    protected $attach1;
    protected $attach2;
    protected $attach3;

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
     * @param mixed $nameDisplay
     */
    public function setNameDisplay($nameDisplay)
    {
        $this->nameDisplay = $nameDisplay;
    }

    /**
     * @return mixed
     */
    public function getNameDisplay()
    {
        return $this->nameDisplay;
    }

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
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }


    /**
     * @param mixed $attach1
     */
    public function setAttach1($attach1)
    {
        $this->attach1 = $attach1;
    }

    /**
     * @return mixed
     */
    public function getAttach1()
    {
        return $this->attach1;
    }

    /**
     * @param mixed $attach2
     */
    public function setAttach2($attach2)
    {
        $this->attach2 = $attach2;
    }

    /**
     * @return mixed
     */
    public function getAttach2()
    {
        return $this->attach2;
    }

    /**
     * @param mixed $attach3
     */
    public function setAttach3($attach3)
    {
        $this->attach3 = $attach3;
    }

    /**
     * @return mixed
     */
    public function getAttach3()
    {
        return $this->attach3;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
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
     * @param mixed $registeredAt
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;
    }

    /**
     * @return mixed
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }


}