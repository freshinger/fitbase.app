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
    protected $questionnaire;

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
}
