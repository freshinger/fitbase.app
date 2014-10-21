<?php

namespace Fitbase\Bundle\GamificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GamificationUserPointlog
 */
class GamificationUserPointlog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $user;

    /**
     * @var integer
     */
    private $countPoint;

    /**
     * @var integer
     */
    private $countPointTotal;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $text;

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set countPoint
     *
     * @param integer $countPoint
     * @return GamificationUserPointlog
     */
    public function setCountPoint($countPoint)
    {
        $this->countPoint = $countPoint;

        return $this;
    }

    /**
     * Get countPoint
     *
     * @return integer
     */
    public function getCountPoint()
    {
        return $this->countPoint;
    }

    /**
     * Set countPointTotal
     *
     * @param integer $countPointTotal
     * @return GamificationUserPointlog
     */
    public function setCountPointTotal($countPointTotal)
    {
        $this->countPointTotal = $countPointTotal;

        return $this;
    }

    /**
     * Get countPointTotal
     *
     * @return integer
     */
    public function getCountPointTotal()
    {
        return $this->countPointTotal;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return GamificationUserPointlog
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
     * Set text
     *
     * @param string $text
     * @return GamificationUserPointlog
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
