<?php

namespace Fitbase\Bundle\ReminderBundle\Entity;

class ReminderUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $user;

    /**
     * @var integer
     */
    protected $pause;

    /**
     * @var datetime
     */
    protected $pauseStart;

    protected $sendWeeklytask;
    protected $sendWeeklyquiz;

    /**
     * @param mixed $sendWeeklyquiz
     */
    public function setSendWeeklyquiz($sendWeeklyquiz)
    {
        $this->sendWeeklyquiz = $sendWeeklyquiz;
    }

    /**
     * @return mixed
     */
    public function getSendWeeklyquiz()
    {
        return (boolean)$this->sendWeeklyquiz;
    }

    /**
     * @param mixed $sendWeeklytask
     */
    public function setSendWeeklytask($sendWeeklytask)
    {
        $this->sendWeeklytask = $sendWeeklytask;
    }

    /**
     * @return mixed
     */
    public function getSendWeeklytask()
    {
        return (boolean)$this->sendWeeklytask;
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
     * @param int $pause
     */
    public function setPause($pause)
    {
        $this->pause = $pause;
    }

    /**
     * @return int
     */
    public function getPause()
    {
        return $this->pause;
    }

    /**
     * @param \Fitbase\Bundle\ReminderBundle\Entity\datetime $pauseStart
     */
    public function setPauseStart($pauseStart)
    {
        $this->pauseStart = $pauseStart;
    }

    /**
     * @return \Fitbase\Bundle\ReminderBundle\Entity\datetime
     */
    public function getPauseStart()
    {
        return $this->pauseStart;
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
}
