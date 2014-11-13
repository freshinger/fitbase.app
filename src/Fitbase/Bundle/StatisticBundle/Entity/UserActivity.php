<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/29/14
 * Time: 2:11 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Entity;


class UserActivity
{
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
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set countPoint
     *
     * @param integer $countPoint
     * @return UserActivity
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
     * @return UserActivity
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
     * @return UserActivity
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
     * @return UserActivity
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
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserActivity
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
