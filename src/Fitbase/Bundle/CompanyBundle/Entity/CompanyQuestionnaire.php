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


    /**
     * Get object name
     * @return mixed|string
     */
    public function __toString()
    {
        $string = "";

        if (($company = $this->getCompany())) {
            $string .= (string)$company->getName();
            if (($questionnaire = $this->getQuestionnaire())) {
                $string .= ': ' . (string)$questionnaire->getName();
            }
        }

        return $string;
    }
}
