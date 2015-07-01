<?php

namespace Wellbeing\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateExerciseRightHandState
 */
class UserStateExerciseRightHandState
{
    /**
     * @var integer
     */
    private $value;

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
     * @param $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return UserStateExerciseRightHandState
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
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
     * @return UserStateExerciseRightHandState
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
