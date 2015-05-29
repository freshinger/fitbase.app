<?php

namespace Wellbeing\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class UserCoordinateShoulderRight
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
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserState
     */
    private $state;


    /**
     * Set x
     *
     * @param float $x
     * @return UserCoordinateShoulderRight
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
     * @return UserCoordinateShoulderRight
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
     * @return UserCoordinateShoulderRight
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
     * Set state
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserState $state
     * @return UserCoordinateShoulderRight
     */
    public function setState(\Wellbeing\Bundle\ApiBundle\Entity\UserState $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Object to string
     * @return string
     */
    public function __toString()
    {
        return "{$this->getX()};{$this->getY()};{$this->getZ()}";
    }
}
