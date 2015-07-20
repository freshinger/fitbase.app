<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserErgonomicsMessage
 */
class UserErgonomicsMessage
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $correct;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var boolean
     */
    private $processed;

    /**
     * @var \DateTime
     */
    private $processedDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set name
     *
     * @param string $name
     * @return UserErgonomicsMessage
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return UserErgonomicsMessage
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set correct
     *
     * @param boolean $correct
     * @return UserErgonomicsMessage
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserErgonomicsMessage
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
     * Set processed
     *
     * @param boolean $processed
     * @return UserErgonomicsMessage
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set processedDate
     *
     * @param \DateTime $processedDate
     * @return UserErgonomicsMessage
     */
    public function setProcessedDate($processedDate)
    {
        $this->processedDate = $processedDate;

        return $this;
    }

    /**
     * Get processedDate
     *
     * @return \DateTime
     */
    public function getProcessedDate()
    {
        return $this->processedDate;
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
     * @return UserErgonomicsMessage
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ergonomics;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ergonomics = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ergonomics
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics $ergonomics
     * @return UserErgonomicsMessage
     */
    public function addErgonomic(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics $ergonomics)
    {
        $this->ergonomics[] = $ergonomics;

        return $this;
    }

    /**
     * Remove ergonomics
     *
     * @param \Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics $ergonomics
     */
    public function removeErgonomic(\Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics $ergonomics)
    {
        $this->ergonomics->removeElement($ergonomics);
    }

    /**
     * Set
     * @param $ergonomics
     * @return $this
     */
    public function setErgonomics($ergonomics)
    {
        $this->ergonomics = $ergonomics;

        return $this;
    }

    /**
     * Get ergonomics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getErgonomics()
    {
        return $this->ergonomics;
    }

    public function onPostPersist()
    {
        if (($collection = $this->getErgonomics())) {
            foreach ($collection as $entity) {
                $entity->setMessage($this);
            }
        }
    }
}
