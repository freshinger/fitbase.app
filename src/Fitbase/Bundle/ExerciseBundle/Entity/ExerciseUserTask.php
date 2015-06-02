<?php

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise
 */
class ExerciseUserTask
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
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    private $exercise0;

    /**
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    private $exercise1;

    /**
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    private $exercise2;


    /**
     * Set exercise0
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise0
     * @return ExerciseUser
     */
    public function setExercise0(\Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise0 = null)
    {
        $this->exercise0 = $exercise0;

        return $this;
    }

    /**
     * Get exercise0
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    public function getExercise0()
    {
        return $this->exercise0;
    }

    /**
     * Set exercise1
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise1
     * @return ExerciseUser
     */
    public function setExercise1(\Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise1 = null)
    {
        $this->exercise1 = $exercise1;

        return $this;
    }

    /**
     * Get exercise1
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    public function getExercise1()
    {
        return $this->exercise1;
    }

    /**
     * Set exercise2
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise2
     * @return ExerciseUser
     */
    public function setExercise2(\Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise2 = null)
    {
        $this->exercise2 = $exercise2;

        return $this;
    }

    /**
     * Get exercise2
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\Exercise
     */
    public function getExercise2()
    {
        return $this->exercise2;
    }

    /**
     * Convert exercise to string
     * @return null|string
     */
    public function __toString()
    {
        if (($exercise = $this->getExercise0())) {
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
     * @return ExerciseUserTask
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
     * @var boolean
     */
    private $exercise0Done;

    /**
     * @var \DateTime
     */
    private $exercise0DoneDate;

    /**
     * @var boolean
     */
    private $exercise1Done;

    /**
     * @var \DateTime
     */
    private $exercise1DoneDate;

    /**
     * @var boolean
     */
    private $exercise2Done;

    /**
     * @var \DateTime
     */
    private $exercise2DoneDate;


    /**
     * Set exercise0Done
     *
     * @param boolean $exercise0Done
     * @return ExerciseUserTask
     */
    public function setExercise0Done($exercise0Done)
    {
        $this->exercise0Done = $exercise0Done;

        return $this;
    }

    /**
     * Get exercise0Done
     *
     * @return boolean 
     */
    public function getExercise0Done()
    {
        return $this->exercise0Done;
    }

    /**
     * Set exercise0DoneDate
     *
     * @param \DateTime $exercise0DoneDate
     * @return ExerciseUserTask
     */
    public function setExercise0DoneDate($exercise0DoneDate)
    {
        $this->exercise0DoneDate = $exercise0DoneDate;

        return $this;
    }

    /**
     * Get exercise0DoneDate
     *
     * @return \DateTime 
     */
    public function getExercise0DoneDate()
    {
        return $this->exercise0DoneDate;
    }

    /**
     * Set exercise1Done
     *
     * @param boolean $exercise1Done
     * @return ExerciseUserTask
     */
    public function setExercise1Done($exercise1Done)
    {
        $this->exercise1Done = $exercise1Done;

        return $this;
    }

    /**
     * Get exercise1Done
     *
     * @return boolean 
     */
    public function getExercise1Done()
    {
        return $this->exercise1Done;
    }

    /**
     * Set exercise1DoneDate
     *
     * @param \DateTime $exercise1DoneDate
     * @return ExerciseUserTask
     */
    public function setExercise1DoneDate($exercise1DoneDate)
    {
        $this->exercise1DoneDate = $exercise1DoneDate;

        return $this;
    }

    /**
     * Get exercise1DoneDate
     *
     * @return \DateTime 
     */
    public function getExercise1DoneDate()
    {
        return $this->exercise1DoneDate;
    }

    /**
     * Set exercise2Done
     *
     * @param boolean $exercise2Done
     * @return ExerciseUserTask
     */
    public function setExercise2Done($exercise2Done)
    {
        $this->exercise2Done = $exercise2Done;

        return $this;
    }

    /**
     * Get exercise2Done
     *
     * @return boolean 
     */
    public function getExercise2Done()
    {
        return $this->exercise2Done;
    }

    /**
     * Set exercise2DoneDate
     *
     * @param \DateTime $exercise2DoneDate
     * @return ExerciseUserTask
     */
    public function setExercise2DoneDate($exercise2DoneDate)
    {
        $this->exercise2DoneDate = $exercise2DoneDate;

        return $this;
    }

    /**
     * Get exercise2DoneDate
     *
     * @return \DateTime 
     */
    public function getExercise2DoneDate()
    {
        return $this->exercise2DoneDate;
    }
}
