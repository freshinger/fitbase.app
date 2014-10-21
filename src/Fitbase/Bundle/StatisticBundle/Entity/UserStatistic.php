<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/29/14
 * Time: 2:11 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Entity;


class UserStatistic
{
    protected $id;
    protected $user;
    protected $userId;
    protected $countVideo;
    protected $countLogin;
    protected $countWeeklyTask;
    protected $countWeeklyTaskProcessed;
    protected $loggedAt;
    protected $userAgent;

    /**
     * @param mixed $countWeeklyTaskProcessed
     */
    public function setCountWeeklyTaskProcessed($countWeeklyTaskProcessed)
    {
        $this->countWeeklyTaskProcessed = $countWeeklyTaskProcessed;
    }

    /**
     * @return mixed
     */
    public function getCountWeeklyTaskProcessed()
    {
        return $this->countWeeklyTaskProcessed;
    }

    /**
     * @param mixed $countLogin
     */
    public function setCountLogin($countLogin)
    {
        $this->countLogin = $countLogin;
    }

    /**
     * @return mixed
     */
    public function getCountLogin()
    {
        return $this->countLogin;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @param mixed $countVideo
     */
    public function setCountVideo($countVideo)
    {
        $this->countVideo = $countVideo;
    }

    /**
     * @return mixed
     */
    public function getCountVideo()
    {
        return $this->countVideo;
    }

    /**
     * @param mixed $countWeeklyTask
     */
    public function setCountWeeklyTask($countWeeklyTask)
    {
        $this->countWeeklyTask = $countWeeklyTask;
    }

    /**
     * @return mixed
     */
    public function getCountWeeklyTask()
    {
        return $this->countWeeklyTask;
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
     * @param mixed $loggedAt
     */
    public function setLoggedAt($loggedAt)
    {
        $this->loggedAt = $loggedAt;
    }

    /**
     * @return mixed
     */
    public function getLoggedAt()
    {
        return $this->loggedAt;
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

} 