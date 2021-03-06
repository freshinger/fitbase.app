<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/29/14
 * Time: 10:43 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


class QuestionnaireAnswer
{
    protected $id;
    protected $name;
    protected $description;
    protected $question;
    protected $countPointStrain;
    protected $countPointHealth;

    /**
     * @param mixed $countPointHealth
     */
    public function setCountPointHealth($countPointHealth)
    {
        $this->countPointHealth = $countPointHealth;
    }

    /**
     * @return mixed
     */
    public function getCountPointHealth()
    {
        return $this->countPointHealth;
    }

    /**
     * @param mixed $countPointStrain
     */
    public function setCountPointStrain($countPointStrain)
    {
        $this->countPointStrain = $countPointStrain;
    }

    /**
     * @return mixed
     */
    public function getCountPointStrain()
    {
        return $this->countPointStrain;
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
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @var \Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire
     */
    private $questionnaire;


    /**
     * Set questionnaire
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire $questionnaire
     * @return QuestionnaireAnswer
     */
    public function setQuestionnaire(\Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return \Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * @var integer
     */
    private $countPoint;


    /**
     * Set countPoint
     *
     * @param integer $countPoint
     * @return QuestionnaireAnswer
     */
    public function setCountPoint($countPoint)
    {
        $this->countPoint = $countPoint;

        return $this;
    }

    /**
     * Get countPoint
     *
     * @return integer
     */
    public function getCountPoint()
    {
        return $this->countPoint;
    }

    /**
     * Get color for this answer
     * @return string
     */
    public function getColor()
    {
        if (($question = $this->getQuestion())) {
            return $question->getAnswerColor($this);
        }
    }
}
