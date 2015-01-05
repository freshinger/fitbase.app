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
    protected $format;

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

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

    /**
     * Add questions
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion $questions
     * @return Questionnaire
     */
    public function addQuestion(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion $questions
     */
    public function removeQuestion(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $company;


    /**
     * Add company
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $company
     * @return Questionnaire
     */
    public function addCompany(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $company)
    {
        $this->company[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $company
     */
    public function removeCompany(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $company)
    {
        $this->company->removeElement($company);
    }

    /**
     * Get company
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireUser;


    /**
     * Add questionnaireUser
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $questionnaireUser
     * @return Questionnaire
     */
    public function addQuestionnaireUser(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $questionnaireUser)
    {
        $this->questionnaireUser[] = $questionnaireUser;

        return $this;
    }

    /**
     * Remove questionnaireUser
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $questionnaireUser
     */
    public function removeQuestionnaireUser(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $questionnaireUser)
    {
        $this->questionnaireUser->removeElement($questionnaireUser);
    }

    /**
     * Get questionnaireUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireUser()
    {
        return $this->questionnaireUser;
    }
}
