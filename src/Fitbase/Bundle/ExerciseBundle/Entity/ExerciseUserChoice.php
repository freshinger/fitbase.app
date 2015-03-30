<?php

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise
 */
class ExerciseUserChoice
{

    /**
     * @var \DateTime
     */
    private $date;

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
     * @return ExerciseUserChoice
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
     * @return ExerciseUserChoice
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
     * @return ExerciseUserChoice
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
}
