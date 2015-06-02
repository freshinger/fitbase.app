<?php

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise
 */
class ExerciseUser
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $done;

    /**
     * @var boolean
     */
    private $processed;

    /**
     * @var \DateTime
     */
    private $doneDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    private $exercise;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ExerciseUser
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
     * Set done
     *
     * @param boolean $done
     * @return ExerciseUser
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set processed
     *
     * @param boolean $processed
     * @return ExerciseUser
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
     * Set doneDate
     *
     * @param \DateTime $doneDate
     * @return ExerciseUser
     */
    public function setDoneDate($doneDate)
    {
        $this->doneDate = $doneDate;

        return $this;
    }

    /**
     * Get doneDate
     *
     * @return \DateTime
     */
    public function getDoneDate()
    {
        return $this->doneDate;
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
     * @return ExerciseUser
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
     * Set exercise
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise
     * @return ExerciseUser
     */
    public function setExercise(\Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise = null)
    {
        $this->exercise = $exercise;

        return $this;
    }

    /**
     * Get exercise
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * Convert exercise to string
     * @return null|string
     */
    public function __toString()
    {
        if (($exercise = $this->getExercise())) {
            return $exercise->getName();
        }
        return null;
    }

    /**
     * @var \DateTime
     */
    private $processedDate;


    /**
     * Set processedDate
     *
     * @param \DateTime $processedDate
     * @return ExerciseUser
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
}
