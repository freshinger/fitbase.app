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
    protected $pause;
    protected $done;
    protected $doneDate;
    protected $countPointHealth;
    protected $countPointStrain;

    /**
     * @return mixed
     */
    public function getPause()
    {
        return $this->pause;
    }

    /**
     * @param mixed $pause
     */
    public function setPause($pause)
    {
        $this->pause = $pause;
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $answers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add answers
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer $answers
     * @return QuestionnaireUser
     */
    public function addAnswer(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer $answers
     */
    public function removeAnswer(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @var integer
     */
    private $countPoint;


    /**
     * Set countPoint
     *
     * @param integer $countPoint
     * @return QuestionnaireUser
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
     * @var \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany
     */
    private $slice;

    /**
     * @var \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire
     */
    private $questionnaire;


    /**
     * Set slice
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $slice
     * @return QuestionnaireUser
     */
    public function setSlice(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany $slice = null)
    {
        $this->slice = $slice;

        return $this;
    }

    /**
     * Get slice
     *
     * @return \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany 
     */
    public function getSlice()
    {
        return $this->slice;
    }

    /**
     * Set questionnaire
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire $questionnaire
     * @return QuestionnaireUser
     */
    public function setQuestionnaire(\Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire 
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }
}
