<?php

namespace Fitbase\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyQuestionnaire
 */
class CompanyQuestionnaire
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $pause;

    /**
     * Set id
     *
     * @param integer $id
     * @return CompanyQuestionnaire
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pause
     *
     * @param integer $pause
     * @return CompanyQuestionnaire
     */
    public function setPause($pause)
    {
        $this->pause = $pause;

        return $this;
    }

    /**
     * Get pause
     *
     * @return integer
     */
    public function getPause()
    {
        return $this->pause;
    }

    /**
     * @var \Fitbase\Bundle\CompanyBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire
     */
    private $questionnaire;


    /**
     * Set company
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\Company $company
     * @return CompanyQuestionnaire
     */
    public function setCompany(\Fitbase\Bundle\CompanyBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Fitbase\Bundle\CompanyBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set questionnaire
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire $questionnaire
     * @return CompanyQuestionnaire
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

    public function getDescription()
    {
        if (($questionnaire = $this->getQuestionnaire())) {
            return $questionnaire->getDescription();
        }
        return null;
    }

    /**
     * Get object name
     * @return mixed|string
     */
    public function __toString()
    {
        $result = [];

        if (($company = $this->getCompany())) {

            array_push($result, $company->getName());
            if (($questionnaire = $this->getQuestionnaire())) {
                array_push($result, $questionnaire->getName());
            }
        }

        return implode(' - ', $result);
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
     * @return CompanyQuestionnaire
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
     * @return CompanyQuestionnaire
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
     * @return CompanyQuestionnaire
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
}
