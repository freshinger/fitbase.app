<?php

namespace Wellbeing\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class UserAuthenticationKey
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var boolean
     */
    private $close;

    /**
     * @var \DateTime
     */
    private $closeDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set code
     *
     * @param string $code
     * @return UserAuthenticationKey
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return UserAuthenticationKey
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set close
     *
     * @param boolean $close
     * @return UserAuthenticationKey
     */
    public function setClose($close)
    {
        $this->close = $close;

        return $this;
    }

    /**
     * Get close
     *
     * @return boolean 
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * Set closeDate
     *
     * @param \DateTime $closeDate
     * @return UserAuthenticationKey
     */
    public function setCloseDate($closeDate)
    {
        $this->closeDate = $closeDate;

        return $this;
    }

    /**
     * Get closeDate
     *
     * @return \DateTime 
     */
    public function getCloseDate()
    {
        return $this->closeDate;
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
     * @return UserAuthenticationKey
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
