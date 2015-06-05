<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/29/14
 * Time: 2:11 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Entity;


class UserActivity
{
    /**
     * @var integer
     */
    private $countPoint;

    /**
     * @var integer
     */
    private $countPointTotal;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $text;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set countPoint
     *
     * @param integer $countPoint
     * @return UserActivity
     */
    public function setCountPoint($countPoint)
    {
        $this->countPoint = $countPoint;

        return $this;
    }

    /**
     * Get countPoint
     *
     * @return integer
     */
    public function getCountPoint()
    {
        return $this->countPoint;
    }

    /**
     * Set countPointTotal
     *
     * @param integer $countPointTotal
     * @return UserActivity
     */
    public function setCountPointTotal($countPointTotal)
    {
        $this->countPointTotal = $countPointTotal;

        return $this;
    }

    /**
     * Get countPointTotal
     *
     * @return integer
     */
    public function getCountPointTotal()
    {
        return $this->countPointTotal;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserActivity
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return UserActivity
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserActivity
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser
     */
    private $exerciseUser;

    /**
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask
     */
    private $exerciseUserTask;

    /**
     * @var \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser
     */
    private $weeklytaskUser;

    /**
     * @var \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser
     */
    private $weeklyquizUser;


    /**
     * Set exerciseUser
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser $exerciseUser
     * @return UserActivity
     */
    public function setExerciseUser(\Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser $exerciseUser = null)
    {
        $this->exerciseUser = $exerciseUser;

        return $this;
    }

    /**
     * Get exerciseUser
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser 
     */
    public function getExerciseUser()
    {
        return $this->exerciseUser;
    }

    /**
     * Set exerciseUserTask
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask $exerciseUserTask
     * @return UserActivity
     */
    public function setExerciseUserTask(\Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask $exerciseUserTask = null)
    {
        $this->exerciseUserTask = $exerciseUserTask;

        return $this;
    }

    /**
     * Get exerciseUserTask
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask 
     */
    public function getExerciseUserTask()
    {
        return $this->exerciseUserTask;
    }

    /**
     * Set weeklytaskUser
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $weeklytaskUser
     * @return UserActivity
     */
    public function setWeeklytaskUser(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $weeklytaskUser = null)
    {
        $this->weeklytaskUser = $weeklytaskUser;

        return $this;
    }

    /**
     * Get weeklytaskUser
     *
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser 
     */
    public function getWeeklytaskUser()
    {
        return $this->weeklytaskUser;
    }

    /**
     * Set weeklyquizUser
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser $weeklyquizUser
     * @return UserActivity
     */
    public function setWeeklyquizUser(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser $weeklyquizUser = null)
    {
        $this->weeklyquizUser = $weeklyquizUser;

        return $this;
    }

    /**
     * Get weeklyquizUser
     *
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser 
     */
    public function getWeeklyquizUser()
    {
        return $this->weeklyquizUser;
    }
    /**
     * @var \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer
     */
    private $weeklyquizUserAnswer;


    /**
     * Set weeklyquizUserAnswer
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer $weeklyquizUserAnswer
     * @return UserActivity
     */
    public function setWeeklyquizUserAnswer(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer $weeklyquizUserAnswer = null)
    {
        $this->weeklyquizUserAnswer = $weeklyquizUserAnswer;

        return $this;
    }

    /**
     * Get weeklyquizUserAnswer
     *
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer 
     */
    public function getWeeklyquizUserAnswer()
    {
        return $this->weeklyquizUserAnswer;
    }
}
