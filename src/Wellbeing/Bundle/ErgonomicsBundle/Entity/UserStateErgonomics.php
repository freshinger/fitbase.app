<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateErgonomics
 */
class UserStateErgonomics
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHead
     */
    private $head;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderCenter
     */
    private $shoulderCenter;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderLeft
     */
    private $shoulderLeft;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderRight
     */
    private $shoulderRight;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowLeft
     */
    private $elbowLeft;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowRight
     */
    private $elbowRight;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandLeft
     */
    private $handLeft;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandRight
     */
    private $handRight;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineMid
     */
    private $spineMid;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsLeanAmount
     */
    private $leanAmount;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHeadRotation
     */
    private $headRotation;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserStateErgonomics
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
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
     * Set head
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHead $head
     * @return UserStateErgonomics
     */
    public function setHead(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHead $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHead 
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set shoulderCenter
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderCenter $shoulderCenter
     * @return UserStateErgonomics
     */
    public function setShoulderCenter(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderCenter $shoulderCenter = null)
    {
        $this->shoulderCenter = $shoulderCenter;

        return $this;
    }

    /**
     * Get shoulderCenter
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderCenter 
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * Set shoulderLeft
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderLeft $shoulderLeft
     * @return UserStateErgonomics
     */
    public function setShoulderLeft(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderLeft $shoulderLeft = null)
    {
        $this->shoulderLeft = $shoulderLeft;

        return $this;
    }

    /**
     * Get shoulderLeft
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderLeft 
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * Set shoulderRight
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderRight $shoulderRight
     * @return UserStateErgonomics
     */
    public function setShoulderRight(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderRight $shoulderRight = null)
    {
        $this->shoulderRight = $shoulderRight;

        return $this;
    }

    /**
     * Get shoulderRight
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderRight 
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * Set elbowLeft
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowLeft $elbowLeft
     * @return UserStateErgonomics
     */
    public function setElbowLeft(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowLeft $elbowLeft = null)
    {
        $this->elbowLeft = $elbowLeft;

        return $this;
    }

    /**
     * Get elbowLeft
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowLeft 
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * Set elbowRight
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowRight $elbowRight
     * @return UserStateErgonomics
     */
    public function setElbowRight(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowRight $elbowRight = null)
    {
        $this->elbowRight = $elbowRight;

        return $this;
    }

    /**
     * Get elbowRight
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowRight 
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * Set handLeft
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandLeft $handLeft
     * @return UserStateErgonomics
     */
    public function setHandLeft(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandLeft $handLeft = null)
    {
        $this->handLeft = $handLeft;

        return $this;
    }

    /**
     * Get handLeft
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandLeft 
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * Set handRight
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandRight $handRight
     * @return UserStateErgonomics
     */
    public function setHandRight(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandRight $handRight = null)
    {
        $this->handRight = $handRight;

        return $this;
    }

    /**
     * Get handRight
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandRight 
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * Set spineMid
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineMid $spineMid
     * @return UserStateErgonomics
     */
    public function setSpineMid(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineMid $spineMid = null)
    {
        $this->spineMid = $spineMid;

        return $this;
    }

    /**
     * Get spineMid
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineMid 
     */
    public function getSpineMid()
    {
        return $this->spineMid;
    }

    /**
     * Set leanAmount
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsLeanAmount $leanAmount
     * @return UserStateErgonomics
     */
    public function setLeanAmount(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsLeanAmount $leanAmount = null)
    {
        $this->leanAmount = $leanAmount;

        return $this;
    }

    /**
     * Get leanAmount
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsLeanAmount 
     */
    public function getLeanAmount()
    {
        return $this->leanAmount;
    }

    /**
     * Set headRotation
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHeadRotation $headRotation
     * @return UserStateErgonomics
     */
    public function setHeadRotation(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHeadRotation $headRotation = null)
    {
        $this->headRotation = $headRotation;

        return $this;
    }

    /**
     * Get headRotation
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHeadRotation 
     */
    public function getHeadRotation()
    {
        return $this->headRotation;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserStateErgonomics
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
