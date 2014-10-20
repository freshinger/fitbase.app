<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 7:58 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


class WeeklytaskPlan
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
    private $weekId;

    /**
     * @var integer
     */
    private $task;

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
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param int $task
     */
    public function setTask($task)
    {
        $this->task = $task;
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