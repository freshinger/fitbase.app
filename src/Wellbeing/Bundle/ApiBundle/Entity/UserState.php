<?php

namespace Wellbeing\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserState
 */
class UserState
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

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
     * Set date
     *
     * @param \DateTime $date
     * @return UserState
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
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $head;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $shoulderLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $shoulderCenter;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $shoulderRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $elbowLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $elbowRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $handLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $handRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $com;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $spine;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $hipLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $hipRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $kneeLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $kneeRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $footLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    private $footRight;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set head
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $head
     * @return UserState
     */
    public function setHead(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set shoulderLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderLeft
     * @return UserState
     */
    public function setShoulderLeft(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderLeft = null)
    {
        $this->shoulderLeft = $shoulderLeft;

        return $this;
    }

    /**
     * Get shoulderLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * Set shoulderCenter
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderCenter
     * @return UserState
     */
    public function setShoulderCenter(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderCenter = null)
    {
        $this->shoulderCenter = $shoulderCenter;

        return $this;
    }

    /**
     * Get shoulderCenter
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * Set shoulderRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderRight
     * @return UserState
     */
    public function setShoulderRight(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderRight = null)
    {
        $this->shoulderRight = $shoulderRight;

        return $this;
    }

    /**
     * Get shoulderRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * Set elbowLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $elbowLeft
     * @return UserState
     */
    public function setElbowLeft(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $elbowLeft = null)
    {
        $this->elbowLeft = $elbowLeft;

        return $this;
    }

    /**
     * Get elbowLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * Set elbowRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $elbowRight
     * @return UserState
     */
    public function setElbowRight(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $elbowRight = null)
    {
        $this->elbowRight = $elbowRight;

        return $this;
    }

    /**
     * Get elbowRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * Set handLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $handLeft
     * @return UserState
     */
    public function setHandLeft(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $handLeft = null)
    {
        $this->handLeft = $handLeft;

        return $this;
    }

    /**
     * Get handLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * Set handRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $handRight
     * @return UserState
     */
    public function setHandRight(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $handRight = null)
    {
        $this->handRight = $handRight;

        return $this;
    }

    /**
     * Get handRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * Set com
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $com
     * @return UserState
     */
    public function setCom(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $com = null)
    {
        $this->com = $com;

        return $this;
    }

    /**
     * Get com
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * Set spine
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $spine
     * @return UserState
     */
    public function setSpine(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $spine = null)
    {
        $this->spine = $spine;

        return $this;
    }

    /**
     * Get spine
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getSpine()
    {
        return $this->spine;
    }

    /**
     * Set hipLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $hipLeft
     * @return UserState
     */
    public function setHipLeft(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $hipLeft = null)
    {
        $this->hipLeft = $hipLeft;

        return $this;
    }

    /**
     * Get hipLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * Set hipRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $hipRight
     * @return UserState
     */
    public function setHipRight(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $hipRight = null)
    {
        $this->hipRight = $hipRight;

        return $this;
    }

    /**
     * Get hipRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * Set kneeLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $kneeLeft
     * @return UserState
     */
    public function setKneeLeft(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $kneeLeft = null)
    {
        $this->kneeLeft = $kneeLeft;

        return $this;
    }

    /**
     * Get kneeLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * Set kneeRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $kneeRight
     * @return UserState
     */
    public function setKneeRight(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $kneeRight = null)
    {
        $this->kneeRight = $kneeRight;

        return $this;
    }

    /**
     * Get kneeRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * Set footLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $footLeft
     * @return UserState
     */
    public function setFootLeft(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $footLeft = null)
    {
        $this->footLeft = $footLeft;

        return $this;
    }

    /**
     * Get footLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * Set footRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $footRight
     * @return UserState
     */
    public function setFootRight(\Wellbeing\Bundle\ApiBundle\Entity\Coordinate $footRight = null)
    {
        $this->footRight = $footRight;

        return $this;
    }

    /**
     * Get footRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate 
     */
    public function getFootRight()
    {
        return $this->footRight;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserState
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
