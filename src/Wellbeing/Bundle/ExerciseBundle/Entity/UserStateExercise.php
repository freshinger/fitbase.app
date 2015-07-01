<?php

namespace Wellbeing\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateExercise
 */
class UserStateExercise
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
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHead
     */
    private $head;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseNeck
     */
    private $neck;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderCenter
     */
    private $shoulderCenter;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderLeft
     */
    private $shoulderLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderRight
     */
    private $shoulderRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowLeft
     */
    private $elbowLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowRight
     */
    private $elbowRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristLeft
     */
    private $wristLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristRight
     */
    private $wristRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandLeft
     */
    private $handLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandRight
     */
    private $handRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbLeft
     */
    private $thumbLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbRight
     */
    private $thumbRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipLeft
     */
    private $handTipLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipRight
     */
    private $handTipRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineMid
     */
    private $spineMid;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineBase
     */
    private $spineBase;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipLeft
     */
    private $hipLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipRight
     */
    private $hipRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeLeft
     */
    private $kneeLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeRight
     */
    private $kneeRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleLeft
     */
    private $ankleLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleRight
     */
    private $ankleRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootLeft
     */
    private $footLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootRight
     */
    private $footRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeftHandState
     */
    private $leftHandState;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseRightHandState
     */
    private $rightHandState;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeanAmount
     */
    private $leanAmount;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHeadRotation
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
     * @return UserStateExercise
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
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHead $head
     * @return UserStateExercise
     */
    public function setHead(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHead $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHead
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set neck
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseNeck $neck
     * @return UserStateExercise
     */
    public function setNeck(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseNeck $neck = null)
    {
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get neck
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseNeck
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set shoulderCenter
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderCenter $shoulderCenter
     * @return UserStateExercise
     */
    public function setShoulderCenter(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderCenter $shoulderCenter = null)
    {
        $this->shoulderCenter = $shoulderCenter;

        return $this;
    }

    /**
     * Get shoulderCenter
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderCenter
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * Set shoulderLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderLeft $shoulderLeft
     * @return UserStateExercise
     */
    public function setShoulderLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderLeft $shoulderLeft = null)
    {
        $this->shoulderLeft = $shoulderLeft;

        return $this;
    }

    /**
     * Get shoulderLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderLeft
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * Set shoulderRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderRight $shoulderRight
     * @return UserStateExercise
     */
    public function setShoulderRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderRight $shoulderRight = null)
    {
        $this->shoulderRight = $shoulderRight;

        return $this;
    }

    /**
     * Get shoulderRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderRight
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * Set elbowLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowLeft $elbowLeft
     * @return UserStateExercise
     */
    public function setElbowLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowLeft $elbowLeft = null)
    {
        $this->elbowLeft = $elbowLeft;

        return $this;
    }

    /**
     * Get elbowLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowLeft
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * Set elbowRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowRight $elbowRight
     * @return UserStateExercise
     */
    public function setElbowRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowRight $elbowRight = null)
    {
        $this->elbowRight = $elbowRight;

        return $this;
    }

    /**
     * Get elbowRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowRight
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * Set wristLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristLeft $wristLeft
     * @return UserStateExercise
     */
    public function setWristLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristLeft $wristLeft = null)
    {
        $this->wristLeft = $wristLeft;

        return $this;
    }

    /**
     * Get wristLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristLeft
     */
    public function getWristLeft()
    {
        return $this->wristLeft;
    }

    /**
     * Set wristRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristRight $wristRight
     * @return UserStateExercise
     */
    public function setWristRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristRight $wristRight = null)
    {
        $this->wristRight = $wristRight;

        return $this;
    }

    /**
     * Get wristRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristRight
     */
    public function getWristRight()
    {
        return $this->wristRight;
    }

    /**
     * Set handLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandLeft $handLeft
     * @return UserStateExercise
     */
    public function setHandLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandLeft $handLeft = null)
    {
        $this->handLeft = $handLeft;

        return $this;
    }

    /**
     * Get handLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandLeft
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * Set handRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandRight $handRight
     * @return UserStateExercise
     */
    public function setHandRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandRight $handRight = null)
    {
        $this->handRight = $handRight;

        return $this;
    }

    /**
     * Get handRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandRight
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * Set thumbLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbLeft $thumbLeft
     * @return UserStateExercise
     */
    public function setThumbLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbLeft $thumbLeft = null)
    {
        $this->thumbLeft = $thumbLeft;

        return $this;
    }

    /**
     * Get thumbLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbLeft
     */
    public function getThumbLeft()
    {
        return $this->thumbLeft;
    }

    /**
     * Set thumbRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbRight $thumbRight
     * @return UserStateExercise
     */
    public function setThumbRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbRight $thumbRight = null)
    {
        $this->thumbRight = $thumbRight;

        return $this;
    }

    /**
     * Get thumbRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbRight
     */
    public function getThumbRight()
    {
        return $this->thumbRight;
    }

    /**
     * Set handTipLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipLeft $handTipLeft
     * @return UserStateExercise
     */
    public function setHandTipLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipLeft $handTipLeft = null)
    {
        $this->handTipLeft = $handTipLeft;

        return $this;
    }

    /**
     * Get handTipLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipLeft
     */
    public function getHandTipLeft()
    {
        return $this->handTipLeft;
    }

    /**
     * Set handTipRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipRight $handTipRight
     * @return UserStateExercise
     */
    public function setHandTipRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipRight $handTipRight = null)
    {
        $this->handTipRight = $handTipRight;

        return $this;
    }

    /**
     * Get handTipRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipRight
     */
    public function getHandTipRight()
    {
        return $this->handTipRight;
    }

    /**
     * Set spineMid
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineMid $spineMid
     * @return UserStateExercise
     */
    public function setSpineMid(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineMid $spineMid = null)
    {
        $this->spineMid = $spineMid;

        return $this;
    }

    /**
     * Get spineMid
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineMid
     */
    public function getSpineMid()
    {
        return $this->spineMid;
    }

    /**
     * Set spineBase
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineBase $spineBase
     * @return UserStateExercise
     */
    public function setSpineBase(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineBase $spineBase = null)
    {
        $this->spineBase = $spineBase;

        return $this;
    }

    /**
     * Get spineBase
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineBase
     */
    public function getSpineBase()
    {
        return $this->spineBase;
    }

    /**
     * Set hipLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipLeft $hipLeft
     * @return UserStateExercise
     */
    public function setHipLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipLeft $hipLeft = null)
    {
        $this->hipLeft = $hipLeft;

        return $this;
    }

    /**
     * Get hipLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipLeft
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * Set hipRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipRight $hipRight
     * @return UserStateExercise
     */
    public function setHipRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipRight $hipRight = null)
    {
        $this->hipRight = $hipRight;

        return $this;
    }

    /**
     * Get hipRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipRight
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * Set kneeLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeLeft $kneeLeft
     * @return UserStateExercise
     */
    public function setKneeLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeLeft $kneeLeft = null)
    {
        $this->kneeLeft = $kneeLeft;

        return $this;
    }

    /**
     * Get kneeLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeLeft
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * Set kneeRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeRight $kneeRight
     * @return UserStateExercise
     */
    public function setKneeRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeRight $kneeRight = null)
    {
        $this->kneeRight = $kneeRight;

        return $this;
    }

    /**
     * Get kneeRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeRight
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * Set ankleLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleLeft $ankleLeft
     * @return UserStateExercise
     */
    public function setAnkleLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleLeft $ankleLeft = null)
    {
        $this->ankleLeft = $ankleLeft;

        return $this;
    }

    /**
     * Get ankleLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleLeft
     */
    public function getAnkleLeft()
    {
        return $this->ankleLeft;
    }

    /**
     * Set ankleRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleRight $ankleRight
     * @return UserStateExercise
     */
    public function setAnkleRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleRight $ankleRight = null)
    {
        $this->ankleRight = $ankleRight;

        return $this;
    }

    /**
     * Get ankleRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleRight
     */
    public function getAnkleRight()
    {
        return $this->ankleRight;
    }

    /**
     * Set footLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootLeft $footLeft
     * @return UserStateExercise
     */
    public function setFootLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootLeft $footLeft = null)
    {
        $this->footLeft = $footLeft;

        return $this;
    }

    /**
     * Get footLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootLeft
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * Set footRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootRight $footRight
     * @return UserStateExercise
     */
    public function setFootRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootRight $footRight = null)
    {
        $this->footRight = $footRight;

        return $this;
    }

    /**
     * Get footRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootRight
     */
    public function getFootRight()
    {
        return $this->footRight;
    }

    /**
     * Set leftHandState
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeftHandState $leftHandState
     * @return UserStateExercise
     */
    public function setLeftHandState(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeftHandState $leftHandState = null)
    {
        $this->leftHandState = $leftHandState;

        return $this;
    }

    /**
     * Get leftHandState
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeftHandState
     */
    public function getLeftHandState()
    {
        return $this->leftHandState;
    }

    /**
     * Set rightHandState
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseRightHandState $rightHandState
     * @return UserStateExercise
     */
    public function setRightHandState(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseRightHandState $rightHandState = null)
    {
        $this->rightHandState = $rightHandState;

        return $this;
    }

    /**
     * Get rightHandState
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseRightHandState
     */
    public function getRightHandState()
    {
        return $this->rightHandState;
    }

    /**
     * Set leanAmount
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeanAmount $leanAmount
     * @return UserStateExercise
     */
    public function setLeanAmount(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeanAmount $leanAmount = null)
    {
        $this->leanAmount = $leanAmount;

        return $this;
    }

    /**
     * Get leanAmount
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeanAmount
     */
    public function getLeanAmount()
    {
        return $this->leanAmount;
    }

    /**
     * Set headRotation
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHeadRotation $headRotation
     * @return UserStateExercise
     */
    public function setHeadRotation(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHeadRotation $headRotation = null)
    {
        $this->headRotation = $headRotation;

        return $this;
    }

    /**
     * Get headRotation
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHeadRotation
     */
    public function getHeadRotation()
    {
        return $this->headRotation;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserStateExercise
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
        $this->getHead()->setUserState($this);
        $this->getNeck()->setUserState($this);
        $this->getShoulderCenter()->setUserState($this);
        $this->getShoulderLeft()->setUserState($this);
        $this->getShoulderRight()->setUserState($this);
        $this->getElbowLeft()->setUserState($this);
        $this->getElbowRight()->setUserState($this);
        $this->getWristLeft()->setUserState($this);
        $this->getWristRight()->setUserState($this);
        $this->getHandLeft()->setUserState($this);
        $this->getHandRight()->setUserState($this);
        $this->getThumbLeft()->setUserState($this);
        $this->getThumbRight()->setUserState($this);
        $this->getHandTipLeft()->setUserState($this);
        $this->getHandTipRight()->setUserState($this);
        $this->getSpineMid()->setUserState($this);
        $this->getSpineBase()->setUserState($this);
        $this->getHipLeft()->setUserState($this);
        $this->getHipRight()->setUserState($this);
        $this->getKneeLeft()->setUserState($this);
        $this->getKneeRight()->setUserState($this);
        $this->getAnkleLeft()->setUserState($this);
        $this->getAnkleRight()->setUserState($this);
        $this->getFootLeft()->setUserState($this);
        $this->getFootRight()->setUserState($this);
        $this->getLeftHandState()->setUserState($this);
        $this->getRightHandState()->setUserState($this);
        $this->getLeanAmount()->setUserState($this);
        $this->getHeadRotation()->setUserState($this);
    }
}
