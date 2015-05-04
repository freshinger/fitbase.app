<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/04/15
 * Time: 10:28
 */
namespace Fitbase\Bundle\UserBundle\Model;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentUserInvite
{
    protected $file;

    protected $company;

    protected $text;

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        print_r($this->getFile());
    }

}