<?php

namespace Wellbeing\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserState
 */
class UserState
{
    /**
     *
     * @var
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
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHead
     */
    private $head;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderLeft
     */
    private $shoulderLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderCenter
     */
    private $shoulderCenter;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderRight
     */
    private $shoulderRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowLeft
     */
    private $elbowLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowRight
     */
    private $elbowRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandLeft
     */
    private $handLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandRight
     */
    private $handRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateCom
     */
    private $com;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateSpine
     */
    private $spine;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipLeft
     */
    private $hipLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipRight
     */
    private $hipRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeLeft
     */
    private $kneeLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeRight
     */
    private $kneeRight;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootLeft
     */
    private $footLeft;

    /**
     * @var \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootRight
     */
    private $footRight;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


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
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHead $head
     * @return UserState
     */
    public function setHead(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHead $head = null)
    {
        $head->setState($this);

        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHead
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set shoulderLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderLeft $shoulderLeft
     * @return UserState
     */
    public function setShoulderLeft(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderLeft $shoulderLeft = null)
    {
        $shoulderLeft->setState($this);

        $this->shoulderLeft = $shoulderLeft;

        return $this;
    }

    /**
     * Get shoulderLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderLeft
     */
    public function getShoulderLeft()
    {
        return $this->shoulderLeft;
    }

    /**
     * Set shoulderCenter
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderCenter $shoulderCenter
     * @return UserState
     */
    public function setShoulderCenter(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderCenter $shoulderCenter = null)
    {
        $shoulderCenter->setState($this);

        $this->shoulderCenter = $shoulderCenter;

        return $this;
    }

    /**
     * Get shoulderCenter
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderCenter
     */
    public function getShoulderCenter()
    {
        return $this->shoulderCenter;
    }

    /**
     * Set shoulderRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderRight $shoulderRight
     * @return UserState
     */
    public function setShoulderRight(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderRight $shoulderRight = null)
    {
        $shoulderRight->setState($this);

        $this->shoulderRight = $shoulderRight;

        return $this;
    }

    /**
     * Get shoulderRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderRight
     */
    public function getShoulderRight()
    {
        return $this->shoulderRight;
    }

    /**
     * Set elbowLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowLeft $elbowLeft
     * @return UserState
     */
    public function setElbowLeft(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowLeft $elbowLeft = null)
    {
        $elbowLeft->setState($this);

        $this->elbowLeft = $elbowLeft;

        return $this;
    }

    /**
     * Get elbowLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowLeft
     */
    public function getElbowLeft()
    {
        return $this->elbowLeft;
    }

    /**
     * Set elbowRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowRight $elbowRight
     * @return UserState
     */
    public function setElbowRight(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowRight $elbowRight = null)
    {
        $elbowRight->setState($this);

        $this->elbowRight = $elbowRight;

        return $this;
    }

    /**
     * Get elbowRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowRight
     */
    public function getElbowRight()
    {
        return $this->elbowRight;
    }

    /**
     * Set handLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandLeft $handLeft
     * @return UserState
     */
    public function setHandLeft(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandLeft $handLeft = null)
    {
        $handLeft->setState($this);

        $this->handLeft = $handLeft;

        return $this;
    }

    /**
     * Get handLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandLeft
     */
    public function getHandLeft()
    {
        return $this->handLeft;
    }

    /**
     * Set handRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandRight $handRight
     * @return UserState
     */
    public function setHandRight(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandRight $handRight = null)
    {
        $handRight->setState($this);

        $this->handRight = $handRight;

        return $this;
    }

    /**
     * Get handRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandRight
     */
    public function getHandRight()
    {
        return $this->handRight;
    }

    /**
     * Set com
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateCom $com
     * @return UserState
     */
    public function setCom(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateCom $com = null)
    {
        $com->setState($this);

        $this->com = $com;

        return $this;
    }

    /**
     * Get com
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateCom
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * Set spine
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateSpine $spine
     * @return UserState
     */
    public function setSpine(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateSpine $spine = null)
    {
        $spine->setState($this);

        $this->spine = $spine;

        return $this;
    }

    /**
     * Get spine
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateSpine
     */
    public function getSpine()
    {
        return $this->spine;
    }

    /**
     * Set hipLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipLeft $hipLeft
     * @return UserState
     */
    public function setHipLeft(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipLeft $hipLeft = null)
    {
        $hipLeft->setState($this);

        $this->hipLeft = $hipLeft;

        return $this;
    }

    /**
     * Get hipLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipLeft
     */
    public function getHipLeft()
    {
        return $this->hipLeft;
    }

    /**
     * Set hipRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipRight $hipRight
     * @return UserState
     */
    public function setHipRight(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipRight $hipRight = null)
    {
        $hipRight->setState($this);

        $this->hipRight = $hipRight;

        return $this;
    }

    /**
     * Get hipRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipRight
     */
    public function getHipRight()
    {
        return $this->hipRight;
    }

    /**
     * Set kneeLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeLeft $kneeLeft
     * @return UserState
     */
    public function setKneeLeft(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeLeft $kneeLeft = null)
    {
        $kneeLeft->setState($this);

        $this->kneeLeft = $kneeLeft;

        return $this;
    }

    /**
     * Get kneeLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeLeft
     */
    public function getKneeLeft()
    {
        return $this->kneeLeft;
    }

    /**
     * Set kneeRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeRight $kneeRight
     * @return UserState
     */
    public function setKneeRight(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeRight $kneeRight = null)
    {

        $kneeRight->setState($this);

        $this->kneeRight = $kneeRight;

        return $this;
    }

    /**
     * Get kneeRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeRight
     */
    public function getKneeRight()
    {
        return $this->kneeRight;
    }

    /**
     * Set footLeft
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootLeft $footLeft
     * @return UserState
     */
    public function setFootLeft(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootLeft $footLeft = null)
    {
        $footLeft->setState($this);

        $this->footLeft = $footLeft;

        return $this;
    }

    /**
     * Get footLeft
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootLeft
     */
    public function getFootLeft()
    {
        return $this->footLeft;
    }

    /**
     * Set footRight
     *
     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootRight $footRight
     * @return UserState
     */
    public function setFootRight(\Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootRight $footRight = null)
    {
        $footRight->setState($this);

        $this->footRight = $footRight;

        return $this;
    }

    /**
     * Get footRight
     *
     * @return \Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootRight
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

    /**
     * Get min X coordinate
     * @return null
     */
    public function getMinXCoordinate()
    {
        $minX = null;

        if (($coordinates = $this->getCoordinates())) {
            foreach ($coordinates as $set) {
                list($x, $y) = $set;
                $minX = (is_null($minX) ? $x : ($x < $minX ? $x : $minX));
            }
        }

        return $minX;
    }

    /**
     * Get min X coordinate
     * @return null
     */
    public function getMaxXCoordinate()
    {
        $maxX = null;

        if (($coordinates = $this->getCoordinates())) {
            foreach ($coordinates as $set) {
                list($x, $y) = $set;
                $maxX = (is_null($maxX) ? $x : ($x > $maxX ? $x : $maxX));
            }
        }

        return $maxX;
    }

    /**
     * Get min Y coordinate
     * @return null
     */
    public function getMinYCoordinate()
    {
        $minY = null;

        if (($coordinates = $this->getCoordinates())) {
            foreach ($coordinates as $set) {
                list($x, $y) = $set;
                $minY = (is_null($minY) ? $y : ($y < $minY ? $y : $minY));
            }

        }

        return $minY;
    }

    /**
     * Get min X coordinate
     * @return null
     */
    public function getMaxYCoordinate()
    {
        $maxY = null;

        if (($coordinates = $this->getCoordinates())) {
            foreach ($coordinates as $set) {
                list($x, $y) = $set;
                $maxY = (is_null($maxY) ? $y : ($y > $maxY ? $y : $maxY));
            }
        }

        return $maxY;
    }

    /**
     * Get array with coordinates
     * @return array
     */
    public function getCoordinates()
    {
        $coordinates = array();

        if (($coordinate = $this->getHead())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }

        if (($coordinate = $this->getShoulderCenter())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getShoulderRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getShoulderLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getElbowRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getElbowLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getHandRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getHandLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getCom())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getSpine())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getHipLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getHipRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getKneeLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getKneeRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getFootLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        if (($coordinate = $this->getFootRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY()));
        }
        return $coordinates;
    }
}
