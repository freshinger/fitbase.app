<?php

namespace Wellbeing\Bundle\StressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateStressShoulderRight
 */
class UserStateStressShoulderRight
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
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStress
     */
    private $userState;

    /**
     * Class constructor
     *
     * @param $x
     * @param $y
     * @param $z
     */
    public function __construct($x, $y, $z)
    {
        $this->setX($x);
        $this->setY($y);
        $this->setZ($z);
    }
    /**
     * Set x
     *
     * @param float $x
     * @return UserStateStressShoulderRight
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
     * @return UserStateStressShoulderRight
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
     * @return UserStateStressShoulderRight
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
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStress $userState
     * @return UserStateStressShoulderRight
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