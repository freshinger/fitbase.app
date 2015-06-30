<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateErgonomicsElbowRight
 */
class UserStateErgonomicsElbowRight
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
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics
     */
    private $userState;


    /**
     * Set x
     *
     * @param float $x
     * @return UserStateErgonomicsElbowRight
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
     * @return UserStateErgonomicsElbowRight
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
     * @return UserStateErgonomicsElbowRight
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
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics $userState
     * @return UserStateErgonomicsElbowRight
     */
    public function setUserState(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics $userState = null)
    {
        $this->userState = $userState;

        return $this;
    }

    /**
     * Get userState
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics 
     */
    public function getUserState()
    {
        return $this->userState;
    }
}
