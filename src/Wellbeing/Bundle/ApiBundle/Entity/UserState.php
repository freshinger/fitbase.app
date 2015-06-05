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
                list($x, $y, $z) = $set;
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
                list($x, $y, $z) = $set;
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
                list($x, $y, $z) = $set;
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
                list($x, $y, $z) = $set;
                $maxY = (is_null($maxY) ? $y : ($y > $maxY ? $y : $maxY));
            }
        }

        return $maxY;
    }

    /**
     * Get min X coordinate
     * @return null
     */
    public function getMaxZCoordinate()
    {
        $maxZ = null;

        if (($coordinates = $this->getCoordinates())) {
            foreach ($coordinates as $set) {
                list($x, $y, $z) = $set;
                $maxZ = (is_null($maxZ) ? $z : ($z > $maxZ ? $z : $maxZ));
            }
        }

        return $maxZ;
    }

    /**
     * Get min Z coordinate
     * @return null
     */
    public function getMinZCoordinate()
    {
        $minZ = null;

        if (($coordinates = $this->getCoordinates())) {
            foreach ($coordinates as $set) {
                list($x, $y, $z) = $set;
                $minZ = (is_null($minZ) ? $z : ($z < $minZ ? $z : $minZ));
            }

        }

        return $minZ;
    }


    /**
     * Get array with coordinates
     * @return array
     */
    public function getCoordinates()
    {
        $coordinates = array();

        if (($coordinate = $this->getHead())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }

        if (($coordinate = $this->getShoulderCenter())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getShoulderRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getShoulderLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getElbowRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getElbowLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getHandRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getHandLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getCom())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getSpine())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getHipLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getHipRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getKneeLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getKneeRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getFootLeft())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        if (($coordinate = $this->getFootRight())) {
            array_push($coordinates, array($coordinate->getX(), $coordinate->getY(), $coordinate->getZ()));
        }
        return $coordinates;
    }

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $media;


    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return UserState
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $preview1;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $preview2;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $preview3;


    /**
     * Set preview1
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $preview1
     * @return UserState
     */
    public function setPreview1(\Application\Sonata\MediaBundle\Entity\Media $preview1 = null)
    {
        $this->preview1 = $preview1;

        return $this;
    }

    /**
     * Get preview1
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getPreview1()
    {
        return $this->preview1;
    }

    /**
     * Set preview2
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $preview2
     * @return UserState
     */
    public function setPreview2(\Application\Sonata\MediaBundle\Entity\Media $preview2 = null)
    {
        $this->preview2 = $preview2;

        return $this;
    }

    /**
     * Get preview2
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getPreview2()
    {
        return $this->preview2;
    }

    /**
     * Set preview3
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $preview3
     * @return UserState
     */
    public function setPreview3(\Application\Sonata\MediaBundle\Entity\Media $preview3 = null)
    {
        $this->preview3 = $preview3;

        return $this;
    }

    /**
     * Get preview3
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getPreview3()
    {
        return $this->preview3;
    }

    /**
     * Get square ShoulderSpine XZ
     *
     * @return float
     */
    public function getSquareXYShoulderRightSpine()
    {
        $x1 = ($this->getShoulderCenter()->getX());
        $x2 = ($this->getShoulderRight()->getX());
        $x3 = ($this->getSpine()->getX());

        $y1 = ($this->getShoulderCenter()->getY());
        $y2 = ($this->getShoulderRight()->getY());
        $y3 = ($this->getSpine()->getY());

        return $this->square($x1, $x2, $x3, $y1, $y2, $y3);
    }

    /**
     * Get square ShoulderSpine XZ
     * @return float
     */
    public function getSquareXZShoulderRightSpine()
    {
        $x1 = ($this->getShoulderCenter()->getX());
        $x2 = ($this->getShoulderRight()->getX());
        $x3 = ($this->getSpine()->getX());

        $z1 = ($this->getShoulderCenter()->getZ());
        $z2 = ($this->getShoulderRight()->getZ());
        $z3 = ($this->getSpine()->getZ());

        return $this->square($x1, $x2, $x3, $z1, $z2, $z3);
    }

    /**
     * Get square ShoulderSpine YZ
     *
     * @return float
     */
    public function getSquareYZShoulderRightSpine()
    {
        $y1 = ($this->getShoulderCenter()->getY());
        $y2 = ($this->getShoulderRight()->getY());
        $y3 = ($this->getSpine()->getY());

        $z1 = ($this->getShoulderCenter()->getZ());
        $z2 = ($this->getShoulderRight()->getZ());
        $z3 = ($this->getSpine()->getZ());

        return $this->square($y1, $y2, $y3, $z1, $z2, $z3);
    }

    /**
     * Get square ShoulderSpine XZ
     *
     * @return float
     */
    public function getSquareXYShoulderLeftSpine()
    {
        $x1 = ($this->getShoulderCenter()->getX());
        $x2 = ($this->getShoulderLeft()->getX());
        $x3 = ($this->getSpine()->getX());

        $y1 = ($this->getShoulderCenter()->getY());
        $y2 = ($this->getShoulderLeft()->getY());
        $y3 = ($this->getSpine()->getY());

        return $this->square($x1, $x2, $x3, $y1, $y2, $y3);
    }

    /**
     * Get square ShoulderSpine XZ
     * @return float
     */
    public function getSquareXZShoulderLeftSpine()
    {
        $x1 = ($this->getShoulderCenter()->getX());
        $x2 = ($this->getShoulderLeft()->getX());
        $x3 = ($this->getSpine()->getX());

        $z1 = ($this->getShoulderCenter()->getZ());
        $z2 = ($this->getShoulderLeft()->getZ());
        $z3 = ($this->getSpine()->getZ());

        return $this->square($x1, $x2, $x3, $z1, $z2, $z3);
    }

    /**
     * Get square ShoulderSpine YZ
     *
     * @return float
     */
    public function getSquareYZShoulderLeftSpine()
    {
        $y1 = ($this->getShoulderCenter()->getY());
        $y2 = ($this->getShoulderLeft()->getY());
        $y3 = ($this->getSpine()->getY());

        $z1 = ($this->getShoulderCenter()->getZ());
        $z2 = ($this->getShoulderLeft()->getZ());
        $z3 = ($this->getSpine()->getZ());

        return $this->square($y1, $y2, $y3, $z1, $z2, $z3);
    }

    public function getSquareXYShoulder()
    {
        $x1 = ($this->getShoulderCenter()->getX());
        $x2 = ($this->getShoulderLeft()->getX());
        $x3 = ($this->getShoulderRight()->getX());

        $y1 = ($this->getShoulderCenter()->getY());
        $y2 = ($this->getShoulderLeft()->getY());
        $y3 = ($this->getShoulderRight()->getY());

        return $this->square($x1, $x2, $x3, $y1, $y2, $y3);
    }

    public function getSquareXZShoulder()
    {
        $x1 = ($this->getShoulderCenter()->getX());
        $x2 = ($this->getShoulderLeft()->getX());
        $x3 = ($this->getShoulderRight()->getX());

        $z1 = ($this->getShoulderCenter()->getZ());
        $z2 = ($this->getShoulderLeft()->getZ());
        $z3 = ($this->getShoulderRight()->getZ());

        return $this->square($x1, $x2, $x3, $z1, $z2, $z3);
    }

    public function getSquareYZShoulder()
    {
        $y1 = ($this->getShoulderCenter()->getY());
        $y2 = ($this->getShoulderLeft()->getY());
        $y3 = ($this->getShoulderRight()->getY());

        $z1 = ($this->getShoulderCenter()->getZ());
        $z2 = ($this->getShoulderLeft()->getZ());
        $z3 = ($this->getShoulderRight()->getZ());

        return $this->square($y1, $y2, $y3, $z1, $z2, $z3);
    }

    /**
     * Calculate triangle square
     * @param $x1
     * @param $x2
     * @param $x3
     * @param $y1
     * @param $y2
     * @param $y3
     * @return float
     */
    protected function square($x1, $x2, $x3, $y1, $y2, $y3)
    {
        $a = sqrt(pow(($x2 - $x1), 2) + pow(($y2 - $y1), 2));
        $b = sqrt(pow(($x3 - $x2), 2) + pow(($y3 - $y2), 2));
        $c = sqrt(pow(($x1 - $x3), 2) + pow(($y1 - $y3), 2));

        $p = ($a + $b + $c) / 2;

        return number_format(sqrt($p * ($p - $a) * ($p - $b) * ($p - $c)), 6) * 1000;
    }
}
