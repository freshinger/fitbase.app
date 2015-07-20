<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserErgonomics
 */
class UserErgonomics
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $processed;

    /**
     * @var \DateTime
     */
    private $processedDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck
     */
    private $neck;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward
     */
    private $bodyUpperForward;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean
     */
    private $bodyUpperLean;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation
     */
    private $bodyUpperRotation;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserErgonomics
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
     * Set processed
     *
     * @param boolean $processed
     * @return UserErgonomics
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set processedDate
     *
     * @param \DateTime $processedDate
     * @return UserErgonomics
     */
    public function setProcessedDate($processedDate)
    {
        $this->processedDate = $processedDate;

        return $this;
    }

    /**
     * Get processedDate
     *
     * @return \DateTime
     */
    public function getProcessedDate()
    {
        return $this->processedDate;
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
     * Set neck
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck $neck
     * @return UserErgonomics
     */
    public function setNeck(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck $neck = null)
    {
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get neck
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set bodyUpperForward
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward $bodyUpperForward
     * @return UserErgonomics
     */
    public function setBodyUpperForward(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward $bodyUpperForward = null)
    {
        $this->bodyUpperForward = $bodyUpperForward;

        return $this;
    }

    /**
     * Get bodyUpperForward
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward
     */
    public function getBodyUpperForward()
    {
        return $this->bodyUpperForward;
    }

    /**
     * Set bodyUpperLean
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean $bodyUpperLean
     * @return UserErgonomics
     */
    public function setBodyUpperLean(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean $bodyUpperLean = null)
    {
        $this->bodyUpperLean = $bodyUpperLean;

        return $this;
    }

    /**
     * Get bodyUpperLean
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean
     */
    public function getBodyUpperLean()
    {
        return $this->bodyUpperLean;
    }

    /**
     * Set bodyUpperRotation
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation $bodyUpperRotation
     * @return UserErgonomics
     */
    public function setBodyUpperRotation(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation $bodyUpperRotation = null)
    {
        $this->bodyUpperRotation = $bodyUpperRotation;

        return $this;
    }

    /**
     * Get bodyUpperRotation
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation
     */
    public function getBodyUpperRotation()
    {
        return $this->bodyUpperRotation;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserErgonomics
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


    public function onPrePersist()
    {
        $this->getNeck()->setErgonomics($this);
        $this->getBodyUpperForward()->setErgonomics($this);
        $this->getBodyUpperLean()->setErgonomics($this);
        $this->getBodyUpperRotation()->setErgonomics($this);
    }
    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage
     */
    private $message;


    /**
     * Set message
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage $message
     * @return UserErgonomics
     */
    public function setMessage(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage $message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage 
     */
    public function getMessage()
    {
        return $this->message;
    }
}
