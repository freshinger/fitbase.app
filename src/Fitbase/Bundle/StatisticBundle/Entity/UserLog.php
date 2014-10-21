<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/28/14
 * Time: 2:17 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Entity;


use Symfony\Component\EventDispatcher\Event;

class UserLog extends Event
{
    protected $date;
    protected $userId;
    protected $userAgent;

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


}