<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 7:58 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


class WeeklyquizPlan
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $user;

    /**
     * @var integer
     */
    private $quiz;

    /**
     * @var integer
     */
    private $weekId;

    /**
     * @var datetime
     */
    private $date;

    /**
     * @var boolean
     */
    private $processed;

    /**
     * @var boolean
     */
    private $processedDate;

    /**
     * @return int
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * @param int $quiz
     */
    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }

    /**
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * @param boolean $processedDate
     */
    public function setProcessedDate($processedDate)
    {
        $this->processedDate = $processedDate;
    }

    /**
     * @return boolean
     */
    public function getProcessedDate()
    {
        return $this->processedDate;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param int $weekId
     */
    public function setWeekId($weekId)
    {
        $this->weekId = $weekId;
    }

    /**
     * @return int
     */
    public function getWeekId()
    {
        return $this->weekId;
    }

    /**
     * Convert object to string
     * @return string
     */
    public function __toString()
    {
        if (($user = $this->getUser())) {
            if (($quiz = $this->getQuiz())) {
                return "{$user}: $quiz";
            }
        }
    }
}
