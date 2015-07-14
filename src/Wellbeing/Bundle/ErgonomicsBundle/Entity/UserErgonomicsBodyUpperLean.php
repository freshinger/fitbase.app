<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserErgonomicsBodyUpperLean
 */
class UserErgonomicsBodyUpperLean
{
    /**
     * @var boolean
     */
    private $correct;

    /**
     * @var float
     */
    private $angle;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set correct
     *
     * @param boolean $correct
     * @return UserErgonomicsBodyUpperLean
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean 
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set angle
     *
     * @param float $angle
     * @return UserErgonomicsBodyUpperLean
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * Get angle
     *
     * @return float 
     */
    public function getAngle()
    {
        return $this->angle;
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
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics
     */
    private $ergonomics;


    /**
     * Set ergonomics
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics $ergonomics
     * @return UserErgonomicsBodyUpperLean
     */
    public function setErgonomics(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics $ergonomics = null)
    {
        $this->ergonomics = $ergonomics;

        return $this;
    }

    /**
     * Get ergonomics
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics 
     */
    public function getErgonomics()
    {
        return $this->ergonomics;
    }

    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->getAngle()}";
    }
}
