<?php

namespace Wellbeing\Bundle\StressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateStressLeftCheekPuff
 */
class UserStateStressLeftCheekPuff
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
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStress
     */
    private $userState;


    /**
     * Set value
     *
     * @param integer $value
     * @return UserStateStressLeftCheekPuff
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
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStress $userState
     * @return UserStateStressLeftCheekPuff
     */
    public function setUserState(\Wellbeing\Bundle\StressBundle\Entity\UserStateStress $userState = null)
    {
        $this->userState = $userState;

        return $this;
    }

    /**
     * Get userState
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStress 
     */
    public function getUserState()
    {
        return $this->userState;
    }
}
