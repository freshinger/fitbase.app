<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/29/14
 * Time: 3:45 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


class QuestionnaireUser
{
    protected $id;
    protected $date;
    protected $user;
    protected $questionnaire;
    protected $questionnaireCompany;
    protected $done;
    protected $doneDate;
    protected $countPointHealth;
    protected $countPointStrain;

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
     * @param mixed $done
     */
    public function setDone($done)
    {
        $this->done = $done;
    }

    /**
     * @return mixed
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * @param mixed $doneDate
     */
    public function setDoneDate($doneDate)
    {
        $this->doneDate = $doneDate;
    }

    /**
     * @return mixed
     */
    public function getDoneDate()
    {
        return $this->doneDate;
    }

    /**
     * @param mixed $questionnaireCompany
     */
    public function setQuestionnaireCompany($questionnaireCompany)
    {
        $this->questionnaireCompany = $questionnaireCompany;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaireCompany()
    {
        return $this->questionnaireCompany;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
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
     * @param mixed $questionnaire
     */
    public function setQuestionnaire($questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
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
}