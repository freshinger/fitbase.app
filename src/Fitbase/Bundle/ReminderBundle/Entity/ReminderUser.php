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

    public function __toString()
    {
        if (($user = $this->getUser())) {
            return "Reminder for: {$user}";
        }
        return null;
    }
}
