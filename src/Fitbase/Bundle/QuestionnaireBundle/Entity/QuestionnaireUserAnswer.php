<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/29/14
 * Time: 3:45 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class QuestionnaireUserAnswer
{
    protected $id;
    protected $user;
    protected $question;
    protected $questionnaireUser;
    protected $answers;
    protected $text;
    protected $countPointHealth;
    protected $countPointStrain;


    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

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
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
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
     * @param \Doctrine\Common\Collections\ArrayCollection $answers
     */
    public function setAnswers($answers)
    {
        if ($answers instanceof QuestionnaireAnswer) {
            $answers = new ArrayCollection(array($answers));
        }

        $this->answers = $answers;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $questionnaireUser
     */
    public function setQuestionnaireUser($questionnaireUser)
    {
        $this->questionnaireUser = $questionnaireUser;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaireUser()
    {
        return $this->questionnaireUser;
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
}