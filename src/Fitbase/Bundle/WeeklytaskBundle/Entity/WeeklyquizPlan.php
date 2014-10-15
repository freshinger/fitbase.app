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
    private $userId;

    /**
     * @var integer
     */
    private $quizId;

    /**
     * @var integer
     */
    private $weekId;

    /**
     * @var integer
     */
    private $weeklytaskId;

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
     * @param int $weeklytaskId
     */
    public function setWeeklytaskId($weeklytaskId)
    {
        $this->weeklytaskId = $weeklytaskId;
    }

    /**
     * @return int
     */
    public function getWeeklytaskId()
    {
        return $this->weeklytaskId;
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
     * @param int $quizId
     */
    public function setQuizId($quizId)
    {
        $this->quizId = $quizId;
    }

    /**
     * @return int
     */
    public function getQuizId()
    {
        return $this->quizId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
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


}