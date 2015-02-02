<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 02/02/15
 * Time: 12:55
 */

namespace Wellbeing\Bundle\ApiBundle\Entity;


class UserState
{
    protected $authkey;
    protected $timestamp;
    protected $head;
    protected $shoulderCenter;
    protected $shoulderLeft;
    protected $shoulderRight;
    protected $elbowLeft;
    protected $elbowRight;
    protected $handLeft;
    protected $handRight;
    protected $com;
    protected $spine;
    protected $hipLeft;
    protected $hipRight;
    protected $kneeLeft;
    protected $kneeRight;
    protected $footLeft;
    protected $footRight;

    /**
     * @return mixed
     */
    public function getAuthkey()
    {
        return $this->authkey;
    }

    /**
     * @param mixed $authkey
     */
    public function setAuthkey($authkey)
    {
        $this->authkey = $authkey;
    }

    /**
     * @return mixed
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * @param mixed $com
     */
    public function setCom($com)
    {
        $this->com = $com;
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
    }

    /**
     * @return mixed
     */
    public function getSpine()
    {
        return $this->spine;
    }

    /**
     * @param mixed $spine
     */
    public function setSpine($spine)
    {
        $this->spine = $spine;
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
    }
}