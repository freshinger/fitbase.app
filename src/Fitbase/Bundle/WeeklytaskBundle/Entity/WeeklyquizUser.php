<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/13/14
 * Time: 12:11 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


class WeeklyquizUser
{
    protected $id;
    protected $quiz;
    protected $user;
    protected $weekId;
    protected $task;
    protected $date;
    protected $code;
    protected $done;
    protected $doneDate;
    protected $countPoint;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $countPoint
     */
    public function setCountPoint($countPoint)
    {
        $this->countPoint = $countPoint;
    }

    /**
     * @return mixed
     */
    public function getCountPoint()
    {
        return $this->countPoint;
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
     * @param mixed $weekId
     */
    public function setWeekId($weekId)
    {
        $this->weekId = $weekId;
    }

    /**
     * @return mixed
     */
    public function getWeekId()
    {
        return $this->weekId;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
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
     * @return mixed
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * @param mixed $quiz
     */
    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param mixed $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * @var boolean
     */
    private $processed;


    /**
     * Set processed
     *
     * @param boolean $processed
     * @return WeeklyquizUser
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
     * @var \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser
     */
    private $userTask;


    /**
     * Set userTask
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $userTask
     * @return WeeklyquizUser
     */
    public function setUserTask(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $userTask = null)
    {
        $this->userTask = $userTask;

        return $this;
    }

    /**
     * Get userTask
     *
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser
     */
    public function getUserTask()
    {
        return $this->userTask;
    }
}
