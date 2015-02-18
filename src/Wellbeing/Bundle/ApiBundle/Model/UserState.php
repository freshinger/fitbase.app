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
    /**
     * @var int
     */
    protected $id;

    /**
     * @var imt
     */
    protected $timestamp;

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
     *
     * @var string
     */
    protected $authKey;

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param $authKey
     * @return $this
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $com
     */
    public function setCom($com)
    {
        $this->com = $com;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $elbowLeft
     */
    public function setElbowLeft($elbowLeft)
    {
        $this->elbowLeft = $elbowLeft;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $elbowRight
     */
    public function setElbowRight($elbowRight)
    {
        $this->elbowRight = $elbowRight;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $footLeft
     */
    public function setFootLeft($footLeft)
    {
        $this->footLeft = $footLeft;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getFootRight()
    {
        return $this->footRight;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $footRight
     */
    public function setFootRight($footRight)
    {
        $this->footRight = $footRight;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $handLeft
     */
    public function setHandLeft($handLeft)
    {
        $this->handLeft = $handLeft;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $handRight
     */
    public function setHandRight($handRight)
    {
        $this->handRight = $handRight;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $head
     */
    public function setHead($head)
    {
        $this->head = $head;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $hipLeft
     */
    public function setHipLeft($hipLeft)
    {
        $this->hipLeft = $hipLeft;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $hipRight
     */
    public function setHipRight($hipRight)
    {
        $this->hipRight = $hipRight;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $kneeLeft
     */
    public function setKneeLeft($kneeLeft)
    {
        $this->kneeLeft = $kneeLeft;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $kneeRight
     */
    public function setKneeRight($kneeRight)
    {
        $this->kneeRight = $kneeRight;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderCenter
     */
    public function setShoulderCenter($shoulderCenter)
    {
        $this->shoulderCenter = $shoulderCenter;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderLeft
     */
    public function setShoulderLeft($shoulderLeft)
    {
        $this->shoulderLeft = $shoulderLeft;
        return $this;

    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $shoulderRight
     */
    public function setShoulderRight($shoulderRight)
    {
        $this->shoulderRight = $shoulderRight;
        return $this;
    }

    /**
     * @return \Wellbeing\Bundle\ApiBundle\Entity\Coordinate
     */
    public function getSpine()
    {
        return $this->spine;
    }

    /**
     * @param \Wellbeing\Bundle\ApiBundle\Entity\Coordinate $spine
     */
    public function setSpine($spine)
    {
        $this->spine = $spine;
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
}