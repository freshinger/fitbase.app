<?php

namespace Wellbeing\Bundle\StressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateStress
 */
class UserStateStress
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
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawOpen
     */
    private $jawOpen;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipPucker
     */
    private $lipPucker;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawSlideRight
     */
    private $jawSlideRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherRight
     */
    private $lipStretcherRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherLeft
     */
    private $lipStretcherLeft;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerLeft
     */
    private $lipCornerPullerLeft;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerRight
     */
    private $lipCornerPullerRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorLeft
     */
    private $lipCornerDepressorLeft;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorRight
     */
    private $lipCornerDepressorRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftCheekPuff
     */
    private $leftCheekPuff;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightCheekPuff
     */
    private $rightCheekPuff;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeClosed
     */
    private $leftEyeClosed;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeClosed
     */
    private $rightEyeClosed;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeBrowLowerer
     */
    private $rightEyeBrowLowerer;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeBrowLowerer
     */
    private $leftEyeBrowLowerer;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorLeft
     */
    private $lowerLipDepressorLeft;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorRight
     */
    private $lowerLipDepressorRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHappy
     */
    private $happy;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHead
     */
    private $head;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderCenter
     */
    private $shoulderCenter;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderLeft
     */
    private $shoulderLeft;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderRight
     */
    private $shoulderRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandLeft
     */
    private $handLeft;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandRight
     */
    private $handRight;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeanAmount
     */
    private $leanAmount;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeadRotation
     */
    private $headRotation;

    /**
     * @var \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeartRate
     */
    private $heartRate;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserStateStress
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
     * Set jawOpen
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawOpen $jawOpen
     * @return UserStateStress
     */
    public function setJawOpen(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawOpen $jawOpen = null)
    {
        $this->jawOpen = $jawOpen;

        return $this;
    }

    /**
     * Get jawOpen
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawOpen
     */
    public function getJawOpen()
    {
        return $this->jawOpen;
    }

    /**
     * Set lipPucker
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipPucker $lipPucker
     * @return UserStateStress
     */
    public function setLipPucker(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipPucker $lipPucker = null)
    {
        $this->lipPucker = $lipPucker;

        return $this;
    }

    /**
     * Get lipPucker
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipPucker
     */
    public function getLipPucker()
    {
        return $this->lipPucker;
    }

    /**
     * Set jawSlideRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawSlideRight $jawSlideRight
     * @return UserStateStress
     */
    public function setJawSlideRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawSlideRight $jawSlideRight = null)
    {
        $this->jawSlideRight = $jawSlideRight;

        return $this;
    }

    /**
     * Get jawSlideRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawSlideRight
     */
    public function getJawSlideRight()
    {
        return $this->jawSlideRight;
    }

    /**
     * Set lipStretcherRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherRight $lipStretcherRight
     * @return UserStateStress
     */
    public function setLipStretcherRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherRight $lipStretcherRight = null)
    {
        $this->lipStretcherRight = $lipStretcherRight;

        return $this;
    }

    /**
     * Get lipStretcherRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherRight
     */
    public function getLipStretcherRight()
    {
        return $this->lipStretcherRight;
    }

    /**
     * Set lipStretcherLeft
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherLeft $lipStretcherLeft
     * @return UserStateStress
     */
    public function setLipStretcherLeft(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherLeft $lipStretcherLeft = null)
    {
        $this->lipStretcherLeft = $lipStretcherLeft;

        return $this;
    }

    /**
     * Get lipStretcherLeft
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherLeft
     */
    public function getLipStretcherLeft()
    {
        return $this->lipStretcherLeft;
    }

    /**
     * Set lipCornerPullerLeft
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerLeft $lipCornerPullerLeft
     * @return UserStateStress
     */
    public function setLipCornerPullerLeft(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerLeft $lipCornerPullerLeft = null)
    {
        $this->lipCornerPullerLeft = $lipCornerPullerLeft;

        return $this;
    }

    /**
     * Get lipCornerPullerLeft
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerLeft
     */
    public function getLipCornerPullerLeft()
    {
        return $this->lipCornerPullerLeft;
    }

    /**
     * Set lipCornerPullerRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerRight $lipCornerPullerRight
     * @return UserStateStress
     */
    public function setLipCornerPullerRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerRight $lipCornerPullerRight = null)
    {
        $this->lipCornerPullerRight = $lipCornerPullerRight;

        return $this;
    }

    /**
     * Get lipCornerPullerRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerRight
     */
    public function getLipCornerPullerRight()
    {
        return $this->lipCornerPullerRight;
    }

    /**
     * Set lipCornerDepressorLeft
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorLeft $lipCornerDepressorLeft
     * @return UserStateStress
     */
    public function setLipCornerDepressorLeft(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorLeft $lipCornerDepressorLeft = null)
    {
        $this->lipCornerDepressorLeft = $lipCornerDepressorLeft;

        return $this;
    }

    /**
     * Get lipCornerDepressorLeft
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorLeft
     */
    public function getLipCornerDepressorLeft()
    {
        return $this->lipCornerDepressorLeft;
    }

    /**
     * Set lipCornerDepressorRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorRight $lipCornerDepressorRight
     * @return UserStateStress
     */
    public function setLipCornerDepressorRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorRight $lipCornerDepressorRight = null)
    {
        $this->lipCornerDepressorRight = $lipCornerDepressorRight;

        return $this;
    }

    /**
     * Get lipCornerDepressorRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorRight
     */
    public function getLipCornerDepressorRight()
    {
        return $this->lipCornerDepressorRight;
    }

    /**
     * Set leftCheekPuff
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftCheekPuff $leftCheekPuff
     * @return UserStateStress
     */
    public function setLeftCheekPuff(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftCheekPuff $leftCheekPuff = null)
    {
        $this->leftCheekPuff = $leftCheekPuff;

        return $this;
    }

    /**
     * Get leftCheekPuff
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftCheekPuff
     */
    public function getLeftCheekPuff()
    {
        return $this->leftCheekPuff;
    }

    /**
     * Set rightCheekPuff
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightCheekPuff $rightCheekPuff
     * @return UserStateStress
     */
    public function setRightCheekPuff(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightCheekPuff $rightCheekPuff = null)
    {
        $this->rightCheekPuff = $rightCheekPuff;

        return $this;
    }

    /**
     * Get rightCheekPuff
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightCheekPuff
     */
    public function getRightCheekPuff()
    {
        return $this->rightCheekPuff;
    }

    /**
     * Set leftEyeClosed
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeClosed $leftEyeClosed
     * @return UserStateStress
     */
    public function setLeftEyeClosed(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeClosed $leftEyeClosed = null)
    {
        $this->leftEyeClosed = $leftEyeClosed;

        return $this;
    }

    /**
     * Get leftEyeClosed
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeClosed
     */
    public function getLeftEyeClosed()
    {
        return $this->leftEyeClosed;
    }

    /**
     * Set rightEyeClosed
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeClosed $rightEyeClosed
     * @return UserStateStress
     */
    public function setRightEyeClosed(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeClosed $rightEyeClosed = null)
    {
        $this->rightEyeClosed = $rightEyeClosed;

        return $this;
    }

    /**
     * Get rightEyeClosed
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeClosed
     */
    public function getRightEyeClosed()
    {
        return $this->rightEyeClosed;
    }

    /**
     * Set rightEyeBrowLowerer
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeBrowLowerer $rightEyeBrowLowerer
     * @return UserStateStress
     */
    public function setRightEyeBrowLowerer(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeBrowLowerer $rightEyeBrowLowerer = null)
    {
        $this->rightEyeBrowLowerer = $rightEyeBrowLowerer;

        return $this;
    }

    /**
     * Get rightEyeBrowLowerer
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeBrowLowerer
     */
    public function getRightEyeBrowLowerer()
    {
        return $this->rightEyeBrowLowerer;
    }

    /**
     * Set leftEyeBrowLowerer
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeBrowLowerer $leftEyeBrowLowerer
     * @return UserStateStress
     */
    public function setLeftEyeBrowLowerer(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeBrowLowerer $leftEyeBrowLowerer = null)
    {
        $this->leftEyeBrowLowerer = $leftEyeBrowLowerer;

        return $this;
    }

    /**
     * Get leftEyeBrowLowerer
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeBrowLowerer
     */
    public function getLeftEyeBrowLowerer()
    {
        return $this->leftEyeBrowLowerer;
    }

    /**
     * Set lowerLipDepressorLeft
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorLeft $lowerLipDepressorLeft
     * @return UserStateStress
     */
    public function setLowerLipDepressorLeft(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorLeft $lowerLipDepressorLeft = null)
    {
        $this->lowerLipDepressorLeft = $lowerLipDepressorLeft;

        return $this;
    }

    /**
     * Get lowerLipDepressorLeft
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorLeft
     */
    public function getLowerLipDepressorLeft()
    {
        return $this->lowerLipDepressorLeft;
    }

    /**
     * Set lowerLipDepressorRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorRight $lowerLipDepressorRight
     * @return UserStateStress
     */
    public function setLowerLipDepressorRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorRight $lowerLipDepressorRight = null)
    {
        $this->lowerLipDepressorRight = $lowerLipDepressorRight;

        return $this;
    }

    /**
     * Get lowerLipDepressorRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorRight
     */
    public function getLowerLipDepressorRight()
    {
        return $this->lowerLipDepressorRight;
    }

    /**
     * Set happy
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHappy $happy
     * @return UserStateStress
     */
    public function setHappy(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressHappy $happy = null)
    {
        $this->happy = $happy;

        return $this;
    }

    /**
     * Get happy
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHappy
     */
    public function getHappy()
    {
        return $this->happy;
    }

    /**
     * Set head
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHead $head
     * @return UserStateStress
     */
    public function setHead(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressHead $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHead
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set shoulderCenter
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderCenter $shoulderCenter
     * @return UserStateStress
     */
    public function setShoulderCenter(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderCenter $shoulderCenter = null)
    {
        $this->shoulderCenter = $shoulderCenter;

        return $this;
    }

    /**
     * Get shoulderCenter
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderCenter
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * Set shoulderLeft
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderLeft $shoulderLeft
     * @return UserStateStress
     */
    public function setShoulderLeft(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderLeft $shoulderLeft = null)
    {
        $this->shoulderLeft = $shoulderLeft;

        return $this;
    }

    /**
     * Get shoulderLeft
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderLeft
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * Set shoulderRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderRight $shoulderRight
     * @return UserStateStress
     */
    public function setShoulderRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderRight $shoulderRight = null)
    {
        $this->shoulderRight = $shoulderRight;

        return $this;
    }

    /**
     * Get shoulderRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderRight
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * Set handLeft
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandLeft $handLeft
     * @return UserStateStress
     */
    public function setHandLeft(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandLeft $handLeft = null)
    {
        $this->handLeft = $handLeft;

        return $this;
    }

    /**
     * Get handLeft
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandLeft
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * Set handRight
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandRight $handRight
     * @return UserStateStress
     */
    public function setHandRight(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandRight $handRight = null)
    {
        $this->handRight = $handRight;

        return $this;
    }

    /**
     * Get handRight
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandRight
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * Set leanAmount
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeanAmount $leanAmount
     * @return UserStateStress
     */
    public function setLeanAmount(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeanAmount $leanAmount = null)
    {
        $this->leanAmount = $leanAmount;

        return $this;
    }

    /**
     * Get leanAmount
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeanAmount
     */
    public function getLeanAmount()
    {
        return $this->leanAmount;
    }

    /**
     * Set headRotation
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeadRotation $headRotation
     * @return UserStateStress
     */
    public function setHeadRotation(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeadRotation $headRotation = null)
    {
        $this->headRotation = $headRotation;

        return $this;
    }

    /**
     * Get headRotation
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeadRotation
     */
    public function getHeadRotation()
    {
        return $this->headRotation;
    }

    /**
     * Set heartRate
     *
     * @param \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeartRate $heartRate
     * @return UserStateStress
     */
    public function setHeartRate(\Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeartRate $heartRate = null)
    {
        $this->heartRate = $heartRate;

        return $this;
    }

    /**
     * Get heartRate
     *
     * @return \Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeartRate
     */
    public function getHeartRate()
    {
        return $this->heartRate;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserStateStress
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
        $this->getJawOpen()->setUserState($this);
        $this->getLipPucker()->setUserState($this);
        $this->getJawSlideRight()->setUserState($this);
        $this->getLipStretcherLeft()->setUserState($this);
        $this->getLipStretcherRight()->setUserState($this);
        $this->getLipCornerPullerLeft()->setUserState($this);
        $this->getLipCornerPullerRight()->setUserState($this);
        $this->getLipCornerDepressorLeft()->setUserState($this);
        $this->getLipCornerDepressorRight()->setUserState($this);
        $this->getLeftCheekPuff()->setUserState($this);
        $this->getRightCheekPuff()->setUserState($this);
        $this->getLeftEyeClosed()->setUserState($this);
        $this->getRightEyeClosed()->setUserState($this);
        $this->getRightEyeBrowLowerer()->setUserState($this);
        $this->getLeftEyeBrowLowerer()->setUserState($this);
        $this->getLowerLipDepressorLeft()->setUserState($this);
        $this->getLowerLipDepressorRight()->setUserState($this);
        $this->getHappy()->setUserState($this);
        $this->getHead()->setUserState($this);
        $this->getShoulderCenter()->setUserState($this);
        $this->getShoulderLeft()->setUserState($this);
        $this->getShoulderRight()->setUserState($this);
        $this->getHandLeft()->setUserState($this);
        $this->getHandRight()->setUserState($this);
        $this->getLeanAmount()->setUserState($this);
        $this->getHeadRotation()->setUserState($this);
        $this->getHeartRate()->setUserState($this);
    }
}
