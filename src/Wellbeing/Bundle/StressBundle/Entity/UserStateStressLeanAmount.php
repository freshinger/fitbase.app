<?php

namespace Wellbeing\Bundle\StressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateStressLeanAmount
 */
class UserStateStressLeanAmount
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
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStress
     */
    private $userState;


    /**
     * Set lr
     *
     * @param integer $lr
     * @return UserStateStressLeanAmount
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
     * @return UserStateStressLeanAmount
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
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStress $userState
     * @return UserStateStressLeanAmount
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
