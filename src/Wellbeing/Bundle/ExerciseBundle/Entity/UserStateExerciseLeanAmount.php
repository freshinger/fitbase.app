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
    private $lr;

    /**
     * @var integer
     */
    private $fb;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise
     */
    private $userState;


    /**
     * Set lr
     *
     * @param integer $lr
     * @return UserStateExerciseLeanAmount
     */
    public function setLr($lr)
    {
        $this->lr = $lr;

        return $this;
    }

    /**
     * Get lr
     *
     * @return integer 
     */
    public function getLr()
    {
        return $this->lr;
    }

    /**
     * Set fb
     *
     * @param integer $fb
     * @return UserStateExerciseLeanAmount
     */
    public function setFb($fb)
    {
        $this->fb = $fb;

        return $this;
    }

    /**
     * Get fb
     *
     * @return integer 
     */
    public function getFb()
    {
        return $this->fb;
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
}
