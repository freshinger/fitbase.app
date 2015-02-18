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
     * @var string
     */
    private $head;

    /**
     * @var string
     */
    private $shoulderLeft;

    /**
     * @var string
     */
    private $shoulderCenter;

    /**
     * @var string
     */
    private $shoulderRight;

    /**
     * @var string
     */
    private $elbowLeft;

    /**
     * @var string
     */
    private $elbowRight;

    /**
     * @var string
     */
    private $handLeft;

    /**
     * @var string
     */
    private $handRight;

    /**
     * @var string
     */
    private $com;

    /**
     * @var string
     */
    private $spine;

    /**
     * @var string
     */
    private $hipLeft;

    /**
     * @var string
     */
    private $hipRight;

    /**
     * @var string
     */
    private $kneeLeft;

    /**
     * @var string
     */
    private $kneeRight;

    /**
     * @var string
     */
    private $footLeft;

    /**
     * @var string
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
     * @return string
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * @param string $com
     */
    public function setCom($com)
    {
        $this->com = $com;
        return $this;

    }

    /**
     * @return string
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * @param string $elbowLeft
     */
    public function setElbowLeft($elbowLeft)
    {
        $this->elbowLeft = $elbowLeft;
        return $this;

    }

    /**
     * @return string
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * @param string $elbowRight
     */
    public function setElbowRight($elbowRight)
    {
        $this->elbowRight = $elbowRight;
        return $this;

    }

    /**
     * @return string
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * @param string $footLeft
     */
    public function setFootLeft($footLeft)
    {
        $this->footLeft = $footLeft;
        return $this;

    }

    /**
     * @return string
     */
    public function getFootRight()
    {
        return $this->footRight;
    }

    /**
     * @param string $footRight
     */
    public function setFootRight($footRight)
    {
        $this->footRight = $footRight;
        return $this;

    }

    /**
     * @return string
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * @param string $handLeft
     */
    public function setHandLeft($handLeft)
    {
        $this->handLeft = $handLeft;
        return $this;

    }

    /**
     * @return string
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * @param string $handRight
     */
    public function setHandRight($handRight)
    {
        $this->handRight = $handRight;
        return $this;

    }

    /**
     * @return string
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param string $head
     */
    public function setHead($head)
    {
        $this->head = $head;
        return $this;

    }

    /**
     * @return string
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * @param string $hipLeft
     */
    public function setHipLeft($hipLeft)
    {
        $this->hipLeft = $hipLeft;
        return $this;

    }

    /**
     * @return string
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * @param string $hipRight
     */
    public function setHipRight($hipRight)
    {
        $this->hipRight = $hipRight;
        return $this;

    }

    /**
     * @return string
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * @param string $kneeLeft
     */
    public function setKneeLeft($kneeLeft)
    {
        $this->kneeLeft = $kneeLeft;
        return $this;

    }

    /**
     * @return string
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * @param string $kneeRight
     */
    public function setKneeRight($kneeRight)
    {
        $this->kneeRight = $kneeRight;
        return $this;

    }

    /**
     * @return string
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * @param string $shoulderCenter
     */
    public function setShoulderCenter($shoulderCenter)
    {
        $this->shoulderCenter = $shoulderCenter;
        return $this;

    }

    /**
     * @return string
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * @param string $shoulderLeft
     */
    public function setShoulderLeft($shoulderLeft)
    {
        $this->shoulderLeft = $shoulderLeft;
        return $this;

    }

    /**
     * @return string
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * @param string $shoulderRight
     */
    public function setShoulderRight($shoulderRight)
    {
        $this->shoulderRight = $shoulderRight;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpine()
    {
        return $this->spine;
    }

    /**
     * @param string $spine
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

    public function toArray()
    {
        return array(
            "authKey" => $this->getAuthKey(),
        );
    }
}