<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 8:38 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


class WeeklytaskUser
{
    protected $id;
    protected $user;
    protected $weekId;
    protected $task;
    protected $code;
    protected $date;
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
        return $this;
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
        return $this;
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
        return (int)$this->countPoint;
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
     * Convert object to string
     * @return null|string
     */
    public function __toString()
    {
        if (($user = $this->getUser())) {
            if (($task = $this->getTask())) {
                return "{$user}: {$task}";
            }
        }
        return null;
    }

    /**
     * @var boolean
     */
    private $processed;


    /**
     * Set processed
     *
     * @param boolean $processed
     * @return WeeklytaskUser
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
     * @var \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser
     */
    private $userQuiz;


    /**
     * Set userQuiz
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser $userQuiz
     * @return WeeklytaskUser
     */
    public function setUserQuiz(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser $userQuiz = null)
    {
        $this->userQuiz = $userQuiz;

        return $this;
    }

    /**
     * Get userQuiz
     *
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser
     */
    public function getUserQuiz()
    {
        return $this->userQuiz;
    }
    /**
     * @var \DateTime
     */
    private $processedDate;

    /**
     * @var boolean
     */
    private $error;

    /**
     * @var \DateTime
     */
    private $errorDate;

    /**
     * @var string
     */
    private $errorMessage;


    /**
     * Set processedDate
     *
     * @param \DateTime $processedDate
     * @return WeeklytaskUser
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
     * Set error
     *
     * @param boolean $error
     * @return WeeklytaskUser
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return boolean 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set errorDate
     *
     * @param \DateTime $errorDate
     * @return WeeklytaskUser
     */
    public function setErrorDate($errorDate)
    {
        $this->errorDate = $errorDate;

        return $this;
    }

    /**
     * Get errorDate
     *
     * @return \DateTime 
     */
    public function getErrorDate()
    {
        return $this->errorDate;
    }

    /**
     * Set errorMessage
     *
     * @param string $errorMessage
     * @return WeeklytaskUser
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get errorMessage
     *
     * @return string 
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
