<?php

namespace Wellbeing\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateExerciseLeanAmount
 */
class UserStateExerciseLeanAmount
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise
     */
    private $userState;


    /**
     * Class constructor
     *
     * @param $x
     * @param $y
     * @param $z
     */
    public function __construct($x, $y)
    {
        $this->setX($x);
        $this->setY($y);
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
     * @return UserStateExerciseLeanAmount
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

    /**
     * @var integer
     */
    private $x;

    /**
     * @var integer
     */
    private $y;


    /**
     * Set x
     *
     * @param integer $x
     * @return UserStateExerciseLeanAmount
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     * @return UserStateExerciseLeanAmount
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }
}
