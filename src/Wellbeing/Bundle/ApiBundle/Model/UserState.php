<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 11:16
 */

namespace Wellbeing\Bundle\ApiBundle\Model;


class UserState
{
    public $authKey;
    public $timestamp;
    public $ticketType;
    public $head;
    public $shoulderCenter;
    public $shoulderLeft;
    public $shoulderRight;
    public $elbowLeft;
    public $elbowRight;
    public $handLeft;
    public $handRight;
    public $leanAmount;
    public $headRotation;
    public $neck;
    public $wristLeft;
    public $wristRight;
    public $thumbLeft;
    public $thumbRight;
    public $handTipLeft;
    public $handTipRight;
    public $spineMid;
    public $spineBase;
    public $spineShoulder;
    public $hipLeft;
    public $hipRight;
    public $kneeLeft;
    public $kneeRight;
    public $ankleLeft;
    public $ankleRight;
    public $footLeft;
    public $footRight;
    public $leftHandState;
    public $rightHandState;
    public $jawOpen;
    public $lipPucker;
    public $jawSlideRight;
    public $lipStretcherRight;
    public $lipStretcherLeft;
    public $lipCornerPullerLeft;
    public $lipCornerPullerRight;
    public $lipCornerDepressorLeft;
    public $lipCornerDepressorRight;
    public $leftCheekPuff;
    public $rightCheekPuff;
    public $leftEyeClosed;
    public $rightEyeClosed;
    public $rightEyeBrowLowerer;
    public $leftEyeBrowLowerer;
    public $lowerLipDepressorLeft;
    public $lowerLipDepressorRight;
    public $happy;
    public $heartRate;

    /**
     * @return mixed
     */
    public function getSpineShoulder()
    {
        return $this->spineShoulder;
    }

    /**
     * @param mixed $spineShoulder
     */
    public function setSpineShoulder($spineShoulder)
    {
        $this->spineShoulder = $spineShoulder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * @param mixed $ticketType
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnkleLeft()
    {
        return $this->ankleLeft;
    }

    /**
     * @param mixed $ankleLeft
     */
    public function setAnkleLeft($ankleLeft)
    {
        $this->ankleLeft = $ankleLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnkleRight()
    {
        return $this->ankleRight;
    }

    /**
     * @param mixed $ankleRight
     */
    public function setAnkleRight($ankleRight)
    {
        $this->ankleRight = $ankleRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param mixed $authKey
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * @param mixed $elbowLeft
     */
    public function setElbowLeft($elbowLeft)
    {
        $this->elbowLeft = $elbowLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * @param mixed $elbowRight
     */
    public function setElbowRight($elbowRight)
    {
        $this->elbowRight = $elbowRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * @param mixed $footLeft
     */
    public function setFootLeft($footLeft)
    {
        $this->footLeft = $footLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFootRight()
    {
        return $this->footRight;
    }

    /**
     * @param mixed $footRight
     */
    public function setFootRight($footRight)
    {
        $this->footRight = $footRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * @param mixed $handLeft
     */
    public function setHandLeft($handLeft)
    {
        $this->handLeft = $handLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * @param mixed $handRight
     */
    public function setHandRight($handRight)
    {
        $this->handRight = $handRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHandTipLeft()
    {
        return $this->handTipLeft;
    }

    /**
     * @param mixed $handTipLeft
     */
    public function setHandTipLeft($handTipLeft)
    {
        $this->handTipLeft = $handTipLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHandTipRight()
    {
        return $this->handTipRight;
    }

    /**
     * @param mixed $handTipRight
     */
    public function setHandTipRight($handTipRight)
    {
        $this->handTipRight = $handTipRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHappy()
    {
        return $this->happy;
    }

    /**
     * @param mixed $happy
     */
    public function setHappy($happy)
    {
        $this->happy = $happy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param mixed $head
     */
    public function setHead($head)
    {
        $this->head = $head;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeadRotation()
    {
        return $this->headRotation;
    }

    /**
     * @param mixed $headRotation
     */
    public function setHeadRotation($headRotation)
    {
        $this->headRotation = $headRotation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeartRate()
    {
        return $this->heartRate;
    }

    /**
     * @param mixed $heartRate
     */
    public function setHeartRate($heartRate)
    {
        $this->heartRate = $heartRate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * @param mixed $hipLeft
     */
    public function setHipLeft($hipLeft)
    {
        $this->hipLeft = $hipLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * @param mixed $hipRight
     */
    public function setHipRight($hipRight)
    {
        $this->hipRight = $hipRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJawOpen()
    {
        return $this->jawOpen;
    }

    /**
     * @param mixed $jawOpen
     */
    public function setJawOpen($jawOpen)
    {
        $this->jawOpen = $jawOpen;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJawSlideRight()
    {
        return $this->jawSlideRight;
    }

    /**
     * @param mixed $jawSlideRight
     */
    public function setJawSlideRight($jawSlideRight)
    {
        $this->jawSlideRight = $jawSlideRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * @param mixed $kneeLeft
     */
    public function setKneeLeft($kneeLeft)
    {
        $this->kneeLeft = $kneeLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * @param mixed $kneeRight
     */
    public function setKneeRight($kneeRight)
    {
        $this->kneeRight = $kneeRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeanAmount()
    {
        return $this->leanAmount;
    }

    /**
     * @param mixed $leanAmount
     */
    public function setLeanAmount($leanAmount)
    {
        $this->leanAmount = $leanAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeftCheekPuff()
    {
        return $this->leftCheekPuff;
    }

    /**
     * @param mixed $leftCheekPuff
     */
    public function setLeftCheekPuff($leftCheekPuff)
    {
        $this->leftCheekPuff = $leftCheekPuff;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeftEyeBrowLowerer()
    {
        return $this->leftEyeBrowLowerer;
    }

    /**
     * @param mixed $leftEyeBrowLowerer
     */
    public function setLeftEyeBrowLowerer($leftEyeBrowLowerer)
    {
        $this->leftEyeBrowLowerer = $leftEyeBrowLowerer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeftEyeClosed()
    {
        return $this->leftEyeClosed;
    }

    /**
     * @param mixed $leftEyeClosed
     */
    public function setLeftEyeClosed($leftEyeClosed)
    {
        $this->leftEyeClosed = $leftEyeClosed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeftHandState()
    {
        return $this->leftHandState;
    }

    /**
     * @param mixed $leftHandState
     */
    public function setLeftHandState($leftHandState)
    {
        $this->leftHandState = $leftHandState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipCornerDepressorLeft()
    {
        return $this->lipCornerDepressorLeft;
    }

    /**
     * @param mixed $lipCornerDepressorLeft
     */
    public function setLipCornerDepressorLeft($lipCornerDepressorLeft)
    {
        $this->lipCornerDepressorLeft = $lipCornerDepressorLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipCornerDepressorRight()
    {
        return $this->lipCornerDepressorRight;
    }

    /**
     * @param mixed $lipCornerDepressorRight
     */
    public function setLipCornerDepressorRight($lipCornerDepressorRight)
    {
        $this->lipCornerDepressorRight = $lipCornerDepressorRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipCornerPullerLeft()
    {
        return $this->lipCornerPullerLeft;
    }

    /**
     * @param mixed $lipCornerPullerLeft
     */
    public function setLipCornerPullerLeft($lipCornerPullerLeft)
    {
        $this->lipCornerPullerLeft = $lipCornerPullerLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipCornerPullerRight()
    {
        return $this->lipCornerPullerRight;
    }

    /**
     * @param mixed $lipCornerPullerRight
     */
    public function setLipCornerPullerRight($lipCornerPullerRight)
    {
        $this->lipCornerPullerRight = $lipCornerPullerRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipPucker()
    {
        return $this->lipPucker;
    }

    /**
     * @param mixed $lipPucker
     */
    public function setLipPucker($lipPucker)
    {
        $this->lipPucker = $lipPucker;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipStretcherLeft()
    {
        return $this->lipStretcherLeft;
    }

    /**
     * @param mixed $lipStretcherLeft
     */
    public function setLipStretcherLeft($lipStretcherLeft)
    {
        $this->lipStretcherLeft = $lipStretcherLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLipStretcherRight()
    {
        return $this->lipStretcherRight;
    }

    /**
     * @param mixed $lipStretcherRight
     */
    public function setLipStretcherRight($lipStretcherRight)
    {
        $this->lipStretcherRight = $lipStretcherRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLowerLipDepressorLeft()
    {
        return $this->lowerLipDepressorLeft;
    }

    /**
     * @param mixed $lowerLipDepressorLeft
     */
    public function setLowerLipDepressorLeft($lowerLipDepressorLeft)
    {
        $this->lowerLipDepressorLeft = $lowerLipDepressorLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLowerLipDepressorRight()
    {
        return $this->lowerLipDepressorRight;
    }

    /**
     * @param mixed $lowerLipDepressorRight
     */
    public function setLowerLipDepressorRight($lowerLipDepressorRight)
    {
        $this->lowerLipDepressorRight = $lowerLipDepressorRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * @param mixed $neck
     */
    public function setNeck($neck)
    {
        $this->neck = $neck;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRightCheekPuff()
    {
        return $this->rightCheekPuff;
    }

    /**
     * @param mixed $rightCheekPuff
     */
    public function setRightCheekPuff($rightCheekPuff)
    {
        $this->rightCheekPuff = $rightCheekPuff;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRightEyeBrowLowerer()
    {
        return $this->rightEyeBrowLowerer;
    }

    /**
     * @param mixed $rightEyeBrowLowerer
     */
    public function setRightEyeBrowLowerer($rightEyeBrowLowerer)
    {
        $this->rightEyeBrowLowerer = $rightEyeBrowLowerer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRightEyeClosed()
    {
        return $this->rightEyeClosed;
    }

    /**
     * @param mixed $rightEyeClosed
     */
    public function setRightEyeClosed($rightEyeClosed)
    {
        $this->rightEyeClosed = $rightEyeClosed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRightHandState()
    {
        return $this->rightHandState;
    }

    /**
     * @param mixed $rightHandState
     */
    public function setRightHandState($rightHandState)
    {
        $this->rightHandState = $rightHandState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * @param mixed $shoulderCenter
     */
    public function setShoulderCenter($shoulderCenter)
    {
        $this->shoulderCenter = $shoulderCenter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * @param mixed $shoulderLeft
     */
    public function setShoulderLeft($shoulderLeft)
    {
        $this->shoulderLeft = $shoulderLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * @param mixed $shoulderRight
     */
    public function setShoulderRight($shoulderRight)
    {
        $this->shoulderRight = $shoulderRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpineBase()
    {
        return $this->spineBase;
    }

    /**
     * @param mixed $spineBase
     */
    public function setSpineBase($spineBase)
    {
        $this->spineBase = $spineBase;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpineMid()
    {
        return $this->spineMid;
    }

    /**
     * @param mixed $spineMid
     */
    public function setSpineMid($spineMid)
    {
        $this->spineMid = $spineMid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbLeft()
    {
        return $this->thumbLeft;
    }

    /**
     * @param mixed $thumbLeft
     */
    public function setThumbLeft($thumbLeft)
    {
        $this->thumbLeft = $thumbLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbRight()
    {
        return $this->thumbRight;
    }

    /**
     * @param mixed $thumbRight
     */
    public function setThumbRight($thumbRight)
    {
        $this->thumbRight = $thumbRight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWristLeft()
    {
        return $this->wristLeft;
    }

    /**
     * @param mixed $wristLeft
     */
    public function setWristLeft($wristLeft)
    {
        $this->wristLeft = $wristLeft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWristRight()
    {
        return $this->wristRight;
    }

    /**
     * @param mixed $wristRight
     */
    public function setWristRight($wristRight)
    {
        $this->wristRight = $wristRight;
        return $this;
    }

    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }


}