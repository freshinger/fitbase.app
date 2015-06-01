<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 01/06/15
 * Time: 13:35
 */

namespace Fitbase\Bundle\ExerciseBundle\Entity;


class ExerciseUserReminder
{

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $processed;

    /**
     * @var \DateTime
     */
    private $processedDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ExerciseUserReminder
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
     * Set processed
     *
     * @param boolean $processed
     * @return ExerciseUserReminder
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
     * Set processedDate
     *
     * @param \DateTime $processedDate
     * @return ExerciseUserReminder
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
     * @return ExerciseUserReminder
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
     * @var boolean
     */
    private $error;

    /**
     * @var boolean
     */
    private $errorMessage;


    /**
     * Set error
     *
     * @param boolean $error
     * @return ExerciseUserReminder
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
     * Set errorMessage
     *
     * @param boolean $errorMessage
     * @return ExerciseUserReminder
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get errorMessage
     *
     * @return boolean 
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
