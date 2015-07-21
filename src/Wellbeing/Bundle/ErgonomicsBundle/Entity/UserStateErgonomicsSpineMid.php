<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateErgonomicsSpineMid
 */
class UserStateErgonomicsSpineMid
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
     * @return UserStateErgonomicsSpineMid
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
        return (float)$this->x;
    }

    /**
     * Set y
     *
     * @param float $y
     * @return UserStateErgonomicsSpineMid
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
        return (float)$this->y;
    }

    /**
     * Set z
     *
     * @param float $z
     * @return UserStateErgonomicsSpineMid
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
        return (float)$this->z;
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
     * @return UserStateErgonomicsSpineMid
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

    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->getX()}; {$this->getY()}; {$this->getZ()}";
    }
}
