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
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHead
     */
    private $head;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressNeck
     */
    private $neck;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderCenter
     */
    private $shoulderCenter;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderLeft
     */
    private $shoulderLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderRight
     */
    private $shoulderRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowLeft
     */
    private $elbowLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowRight
     */
    private $elbowRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristLeft
     */
    private $wristLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristRight
     */
    private $wristRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandLeft
     */
    private $handLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandRight
     */
    private $handRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbLeft
     */
    private $thumbLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbRight
     */
    private $thumbRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipLeft
     */
    private $handTipLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipRight
     */
    private $handTipRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineMid
     */
    private $spineMid;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineBase
     */
    private $spineBase;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipLeft
     */
    private $hipLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipRight
     */
    private $hipRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeLeft
     */
    private $kneeLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeRight
     */
    private $kneeRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleLeft
     */
    private $ankleLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleRight
     */
    private $ankleRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootLeft
     */
    private $footLeft;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootRight
     */
    private $footRight;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeftHandState
     */
    private $leftHandState;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressRightHandState
     */
    private $rightHandState;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeanAmount
     */
    private $leanAmount;

    /**
     * @var \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHeadRotation
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
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHead $head
     * @return UserStateExercise
     */
    public function setHead(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHead $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHead 
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set neck
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressNeck $neck
     * @return UserStateExercise
     */
    public function setNeck(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressNeck $neck = null)
    {
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get neck
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressNeck 
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set shoulderCenter
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderCenter $shoulderCenter
     * @return UserStateExercise
     */
    public function setShoulderCenter(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderCenter $shoulderCenter = null)
    {
        $this->shoulderCenter = $shoulderCenter;

        return $this;
    }

    /**
     * Get shoulderCenter
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderCenter 
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * Set shoulderLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderLeft $shoulderLeft
     * @return UserStateExercise
     */
    public function setShoulderLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderLeft $shoulderLeft = null)
    {
        $this->shoulderLeft = $shoulderLeft;

        return $this;
    }

    /**
     * Get shoulderLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderLeft 
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * Set shoulderRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderRight $shoulderRight
     * @return UserStateExercise
     */
    public function setShoulderRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderRight $shoulderRight = null)
    {
        $this->shoulderRight = $shoulderRight;

        return $this;
    }

    /**
     * Get shoulderRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressShoulderRight 
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * Set elbowLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowLeft $elbowLeft
     * @return UserStateExercise
     */
    public function setElbowLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowLeft $elbowLeft = null)
    {
        $this->elbowLeft = $elbowLeft;

        return $this;
    }

    /**
     * Get elbowLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowLeft 
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * Set elbowRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowRight $elbowRight
     * @return UserStateExercise
     */
    public function setElbowRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowRight $elbowRight = null)
    {
        $this->elbowRight = $elbowRight;

        return $this;
    }

    /**
     * Get elbowRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressElbowRight 
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * Set wristLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristLeft $wristLeft
     * @return UserStateExercise
     */
    public function setWristLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristLeft $wristLeft = null)
    {
        $this->wristLeft = $wristLeft;

        return $this;
    }

    /**
     * Get wristLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristLeft 
     */
    public function getWristLeft()
    {
        return $this->wristLeft;
    }

    /**
     * Set wristRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristRight $wristRight
     * @return UserStateExercise
     */
    public function setWristRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristRight $wristRight = null)
    {
        $this->wristRight = $wristRight;

        return $this;
    }

    /**
     * Get wristRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressWristRight 
     */
    public function getWristRight()
    {
        return $this->wristRight;
    }

    /**
     * Set handLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandLeft $handLeft
     * @return UserStateExercise
     */
    public function setHandLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandLeft $handLeft = null)
    {
        $this->handLeft = $handLeft;

        return $this;
    }

    /**
     * Get handLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandLeft 
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * Set handRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandRight $handRight
     * @return UserStateExercise
     */
    public function setHandRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandRight $handRight = null)
    {
        $this->handRight = $handRight;

        return $this;
    }

    /**
     * Get handRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandRight 
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * Set thumbLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbLeft $thumbLeft
     * @return UserStateExercise
     */
    public function setThumbLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbLeft $thumbLeft = null)
    {
        $this->thumbLeft = $thumbLeft;

        return $this;
    }

    /**
     * Get thumbLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbLeft 
     */
    public function getThumbLeft()
    {
        return $this->thumbLeft;
    }

    /**
     * Set thumbRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbRight $thumbRight
     * @return UserStateExercise
     */
    public function setThumbRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbRight $thumbRight = null)
    {
        $this->thumbRight = $thumbRight;

        return $this;
    }

    /**
     * Get thumbRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressThumbRight 
     */
    public function getThumbRight()
    {
        return $this->thumbRight;
    }

    /**
     * Set handTipLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipLeft $handTipLeft
     * @return UserStateExercise
     */
    public function setHandTipLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipLeft $handTipLeft = null)
    {
        $this->handTipLeft = $handTipLeft;

        return $this;
    }

    /**
     * Get handTipLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipLeft 
     */
    public function getHandTipLeft()
    {
        return $this->handTipLeft;
    }

    /**
     * Set handTipRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipRight $handTipRight
     * @return UserStateExercise
     */
    public function setHandTipRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipRight $handTipRight = null)
    {
        $this->handTipRight = $handTipRight;

        return $this;
    }

    /**
     * Get handTipRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHandTipRight 
     */
    public function getHandTipRight()
    {
        return $this->handTipRight;
    }

    /**
     * Set spineMid
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineMid $spineMid
     * @return UserStateExercise
     */
    public function setSpineMid(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineMid $spineMid = null)
    {
        $this->spineMid = $spineMid;

        return $this;
    }

    /**
     * Get spineMid
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineMid 
     */
    public function getSpineMid()
    {
        return $this->spineMid;
    }

    /**
     * Set spineBase
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineBase $spineBase
     * @return UserStateExercise
     */
    public function setSpineBase(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineBase $spineBase = null)
    {
        $this->spineBase = $spineBase;

        return $this;
    }

    /**
     * Get spineBase
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressSpineBase 
     */
    public function getSpineBase()
    {
        return $this->spineBase;
    }

    /**
     * Set hipLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipLeft $hipLeft
     * @return UserStateExercise
     */
    public function setHipLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipLeft $hipLeft = null)
    {
        $this->hipLeft = $hipLeft;

        return $this;
    }

    /**
     * Get hipLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipLeft 
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * Set hipRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipRight $hipRight
     * @return UserStateExercise
     */
    public function setHipRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipRight $hipRight = null)
    {
        $this->hipRight = $hipRight;

        return $this;
    }

    /**
     * Get hipRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHipRight 
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * Set kneeLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeLeft $kneeLeft
     * @return UserStateExercise
     */
    public function setKneeLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeLeft $kneeLeft = null)
    {
        $this->kneeLeft = $kneeLeft;

        return $this;
    }

    /**
     * Get kneeLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeLeft 
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * Set kneeRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeRight $kneeRight
     * @return UserStateExercise
     */
    public function setKneeRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeRight $kneeRight = null)
    {
        $this->kneeRight = $kneeRight;

        return $this;
    }

    /**
     * Get kneeRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressKneeRight 
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * Set ankleLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleLeft $ankleLeft
     * @return UserStateExercise
     */
    public function setAnkleLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleLeft $ankleLeft = null)
    {
        $this->ankleLeft = $ankleLeft;

        return $this;
    }

    /**
     * Get ankleLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleLeft 
     */
    public function getAnkleLeft()
    {
        return $this->ankleLeft;
    }

    /**
     * Set ankleRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleRight $ankleRight
     * @return UserStateExercise
     */
    public function setAnkleRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleRight $ankleRight = null)
    {
        $this->ankleRight = $ankleRight;

        return $this;
    }

    /**
     * Get ankleRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressAnkleRight 
     */
    public function getAnkleRight()
    {
        return $this->ankleRight;
    }

    /**
     * Set footLeft
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootLeft $footLeft
     * @return UserStateExercise
     */
    public function setFootLeft(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootLeft $footLeft = null)
    {
        $this->footLeft = $footLeft;

        return $this;
    }

    /**
     * Get footLeft
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootLeft 
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * Set footRight
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootRight $footRight
     * @return UserStateExercise
     */
    public function setFootRight(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootRight $footRight = null)
    {
        $this->footRight = $footRight;

        return $this;
    }

    /**
     * Get footRight
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressFootRight 
     */
    public function getFootRight()
    {
        return $this->footRight;
    }

    /**
     * Set leftHandState
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeftHandState $leftHandState
     * @return UserStateExercise
     */
    public function setLeftHandState(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeftHandState $leftHandState = null)
    {
        $this->leftHandState = $leftHandState;

        return $this;
    }

    /**
     * Get leftHandState
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeftHandState 
     */
    public function getLeftHandState()
    {
        return $this->leftHandState;
    }

    /**
     * Set rightHandState
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressRightHandState $rightHandState
     * @return UserStateExercise
     */
    public function setRightHandState(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressRightHandState $rightHandState = null)
    {
        $this->rightHandState = $rightHandState;

        return $this;
    }

    /**
     * Get rightHandState
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressRightHandState 
     */
    public function getRightHandState()
    {
        return $this->rightHandState;
    }

    /**
     * Set leanAmount
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeanAmount $leanAmount
     * @return UserStateExercise
     */
    public function setLeanAmount(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeanAmount $leanAmount = null)
    {
        $this->leanAmount = $leanAmount;

        return $this;
    }

    /**
     * Get leanAmount
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressLeanAmount 
     */
    public function getLeanAmount()
    {
        return $this->leanAmount;
    }

    /**
     * Set headRotation
     *
     * @param \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHeadRotation $headRotation
     * @return UserStateExercise
     */
    public function setHeadRotation(\Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHeadRotation $headRotation = null)
    {
        $this->headRotation = $headRotation;

        return $this;
    }

    /**
     * Get headRotation
     *
     * @return \Wellbeing\Bundle\ExerciseBundle\Entity\UserStateStressHeadRotation 
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
}
