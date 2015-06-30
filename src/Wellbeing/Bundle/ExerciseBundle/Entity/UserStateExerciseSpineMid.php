<?php

namespace Wellbeing\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateExerciseSpineMid
 */
class UserStateExerciseSpineMid
{
    /**
     * @var float
     */
    private $x;

    /**
     * @var float
     */
    private $y;

    /**
     * @var float
     */
    private $z;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise
     */
    private $userState;


    /**
     * Set x
     *
     * @param float $x
     * @return UserStateExerciseSpineMid
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return float 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param float $y
     * @return UserStateExerciseSpineMid
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return float 
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set z
     *
     * @param float $z
     * @return UserStateExerciseSpineMid
     */
    public function setZ($z)
    {
        $this->z = $z;

        return $this;
    }

    /**
     * Get z
     *
     * @return float 
     */
    public function getZ()
    {
        return $this->z;
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
     * Set userState
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise $userState
     * @return UserStateExerciseSpineMid
     */
    public function setUserState(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise $userState = null)
    {
        $this->userState = $userState;

        return $this;
    }

    /**
     * Get userState
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise 
     */
    public function getUserState()
    {
        return $this->userState;
    }
}
