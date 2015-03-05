<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/1/14
 * Time: 12:19 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


class QuestionnaireCompany
{
    protected $id;
    protected $intervalWeek;
    protected $company;

    /**
     * @param mixed $intervalWeek
     */
    public function setIntervalWeek($intervalWeek)
    {
        $this->intervalWeek = $intervalWeek;
    }

    /**
     * @return mixed
     */
    public function getIntervalWeek()
    {
        return $this->intervalWeek;
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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $processed;

    /**
     * @var \DateTime
     */
    private $processedDate;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return QuestionnaireCompany
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set processed
     *
     * @param boolean $processed
     * @return QuestionnaireCompany
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set processedDate
     *
     * @param \DateTime $processedDate
     * @return QuestionnaireCompany
     */
    public function setProcessedDate($processedDate)
    {
        $this->processedDate = $processedDate;

        return $this;
    }

    /**
     * Get processedDate
     *
     * @return \DateTime
     */
    public function getProcessedDate()
    {
        return $this->processedDate;
    }

    /**
     * @var \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire
     */
    private $questionnaire;

    /**
     * Set questionnaire
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire $questionnaire
     * @return QuestionnaireCompany
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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        if (($questionnaireCompany = $this->getQuestionnaire())) {
            if (($questionnaire = $questionnaireCompany->getQuestionnaire())) {
                return $questionnaire->getDescription();
            }
        }
    }

    public function __toString()
    {
        if (($questionnaireCompany = $this->getQuestionnaire())) {
            if (($questionnaire = $questionnaireCompany->getQuestionnaire())) {
                return $questionnaire->getName();
            }
        }
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaires;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add questionnaires
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires
     * @return QuestionnaireCompany
     */
    public function addQuestionnaire(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Remove questionnaires
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires
     */
    public function removeQuestionnaire(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires)
    {
        $this->questionnaires->removeElement($questionnaires);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }
}
