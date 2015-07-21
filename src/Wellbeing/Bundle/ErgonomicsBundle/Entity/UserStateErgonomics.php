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


    public function onPrePersist()
    {
        $this->getHead()->setUserState($this);
        $this->getShoulderCenter()->setUserState($this);
        $this->getShoulderLeft()->setUserState($this);
        $this->getShoulderRight()->setUserState($this);
        $this->getElbowLeft()->setUserState($this);
        $this->getElbowRight()->setUserState($this);
        $this->getHandLeft()->setUserState($this);
        $this->getHandRight()->setUserState($this);
        $this->getLeanAmount()->setUserState($this);
        $this->getHeadRotation()->setUserState($this);
        $this->getSpineMid()->setUserState($this);
        $this->getSpineBase()->setUserState($this);
        $this->getSpineShoulder()->setUserState($this);
    }

    /**
     * Get neck angle
     *
     * @return float
     */
    public function getAngleNeck()
    {
        list($x1, $y1, $z1) = $this->getVectorNeckXYZ();
        list($x2, $y2, $z2) = $this->getVectorBodyUpperXYZ();

        return $this->getAngleXYZ($x1, $y1, $z1, $x2, $y2, $z2);
    }

    /**
     * Get body left/right angle
     *
     * @return int
     */
    public function getAngleBodyUpperLean()
    {
        return $this->getLeanAmount()->getX();
    }

    /**
     * Get body forward/backward angle
     *
     * @return int
     */
    public function getAngleBodyUpperForward()
    {
        return $this->getLeanAmount()->getY();
    }

    /**
     * Get torsion rotation angle
     *
     * @return float
     */
    public function getAngleBodyUpperRotation()
    {
        list($x1, $z1) = $this->getVectorBodyUpperXZ();
        list($x2, $z2) = $this->getVectorShoulderXZ();

        return $this->getAngleXY($x1, $z1, $x2, $z2);
    }

    /**
     * Get neck vector
     *
     * @return array
     */
    protected function getVectorNeckXYZ()
    {
        $x = $this->getHead()->getX() - $this->getNeck()->getX();
        $y = $this->getHead()->getY() - $this->getNeck()->getY();
        $z = $this->getHead()->getZ() - $this->getNeck()->getZ();

        return [$x, $y, $z];
    }

    /**
     * Get neck vector with 2 coordinates
     *
     * @return array
     */
    protected function getVectorNeckXY()
    {
        $x = $this->getHead()->getX() - $this->getNeck()->getX();
        $y = $this->getHead()->getY() - $this->getNeck()->getY();

        return [$x, $y];
    }

    /**
     * Get vector shoulder with 3 coordinates
     *
     * @return array
     */
    protected function getVectorShoulderXYZ()
    {
        $x = $this->getShoulderRight()->getX() - $this->getShoulderLeft()->getX();
        $y = $this->getShoulderRight()->getY() - $this->getShoulderLeft()->getY();
        $z = $this->getShoulderRight()->getZ() - $this->getShoulderLeft()->getZ();

        return [$x, $y, $z];
    }

    /**
     * Get vector shoulder with 2 coordinates
     *
     * @return array
     */
    protected function getVectorShoulderXZ()
    {
        $x = $this->getShoulderRight()->getX() - $this->getShoulderLeft()->getX();
        $z = $this->getShoulderRight()->getZ() - $this->getShoulderLeft()->getZ();

        return [$x, $z];
    }

    /**
     * Get vector for upper body with 3 coordinates
     *
     * @return array
     */
    protected function getVectorBodyUpperXYZ()
    {
        $x = $this->getSpineShoulder()->getX() - $this->getSpineBase()->getX();
        $y = $this->getSpineShoulder()->getY() - $this->getSpineBase()->getY();
        $z = $this->getSpineShoulder()->getZ() - $this->getSpineBase()->getZ();

        return [$x, $y, $z];
    }

    /**
     * Get vector for upper body with 2 coordinates
     *
     * @return array
     */
    protected function getVectorBodyUpperXZ()
    {
        $x = $this->getSpineShoulder()->getX() - $this->getSpineBase()->getX();
        $z = $this->getSpineShoulder()->getZ() - $this->getSpineBase()->getZ();

        return [$x, $z];
    }

    /**
     * Calculate angle for 2 coordinates coordinates
     *
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @return float
     */
    public function getAngleXY($x1, $y1, $x2, $y2)
    {
        $factor = 180 / M_PI; // from radians to degree
        $winkel_zaehler = ($x1 * $x2) + ($y1 * $y2); // Z‰hler der Winkelberechnung
        $winkel_nenner = (sqrt(($x1 * $x1) + ($y1 * $y1))) * (sqrt(($x2 * $x2) + ($y2 * $y2))); // Nenner der Winkelberechnung
        return (acos($winkel_zaehler / $winkel_nenner)) * $factor; // acos vom Z‰hler und Nenner und Umrechung in Grad
    }

    /**
     * Calculate angle
     * code from reiner with minimal changes
     *
     * @param $x1
     * @param $y1
     * @param $z1
     * @param $x2
     * @param $y2
     * @param $z2
     * @return float
     */
    public function getAngleXYZ($x1, $y1, $z1, $x2, $y2, $z2)
    {
        $factor = 180 / M_PI; // from radians to degree
        $winkel_zaehler = ($x1 * $x2) + ($y1 * $y2) + ($z1 * $z2); // Z‰hler der Winkelberechnung
        $winkel_nenner = (sqrt(($x1 * $x1) + ($y1 * $y1) + ($z1 * $z1))) * (sqrt(($x2 * $x2) + ($y2 * $y2) + ($z2 * $z2))); // Nenner der Winkelberechnung
        return (acos($winkel_zaehler / $winkel_nenner)) * $factor; // acos vom Z‰hler und Nenner und Umrechung in Grad
    }

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsNeck
     */
    private $neck;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineShoulder
     */
    private $spineShoulder;

    /**
     * @var \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineBase
     */
    private $spineBase;


    /**
     * Set neck
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsNeck $neck
     * @return UserStateErgonomics
     */
    public function setNeck(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsNeck $neck = null)
    {
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get neck
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsNeck
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set spineShoulder
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineShoulder $spineShoulder
     * @return UserStateErgonomics
     */
    public function setSpineShoulder(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineShoulder $spineShoulder = null)
    {
        $this->spineShoulder = $spineShoulder;

        return $this;
    }

    /**
     * Get spineShoulder
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineShoulder
     */
    public function getSpineShoulder()
    {
        return $this->spineShoulder;
    }

    /**
     * Set spineBase
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineBase $spineBase
     * @return UserStateErgonomics
     */
    public function setSpineBase(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineBase $spineBase = null)
    {
        $this->spineBase = $spineBase;

        return $this;
    }

    /**
     * Get spineBase
     *
     * @return \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineBase
     */
    public function getSpineBase()
    {
        return $this->spineBase;
    }
}
