<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/19/14
 * Time: 3:16 PM
 */

namespace Fitbase\Bundle\UserBundle\Entity;


class Import
{
    protected $company;
    protected $file;
    protected $attach1;
    protected $attach2;
    protected $attach3;
    protected $text;
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
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
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
}