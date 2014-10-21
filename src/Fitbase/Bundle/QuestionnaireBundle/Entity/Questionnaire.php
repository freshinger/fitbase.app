<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/29/14
 * Time: 10:42 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Questionnaire
{
    protected $id;
    protected $name;
    protected $description;
    protected $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return mixed
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    public function __toString()
    {
        return $this->getName();
    }
}