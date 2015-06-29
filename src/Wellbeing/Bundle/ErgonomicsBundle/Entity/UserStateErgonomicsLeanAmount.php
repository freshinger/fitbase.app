<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStateErgonomicsLeanAmount
 */
class UserStateErgonomicsLeanAmount
{

    /**
     * @var integer
     */
    private $lr;

    /**
     * @var integer
     */
    private $fb;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set lr
     *
     * @param integer $lr
     * @return UserStateErgonomicsLeanAmount
     */
    public function setLr($lr)
    {
        $this->lr = $lr;

        return $this;
    }

    /**
     * Get lr
     *
     * @return integer 
     */
    public function getLr()
    {
        return $this->lr;
    }

    /**
     * Set fb
     *
     * @param integer $fb
     * @return UserStateErgonomicsLeanAmount
     */
    public function setFb($fb)
    {
        $this->fb = $fb;

        return $this;
    }

    /**
     * Get fb
     *
     * @return integer 
     */
    public function getFb()
    {
        return $this->fb;
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
}
