<?php

namespace Fitbase\Bundle\ReminderBundle\Entity;

class ReminderUserPlan
{
    protected $id;
    protected $user;
    protected $reminder;
    protected $item;
    protected $date;
    protected $processed;

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @param mixed $reminder
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
