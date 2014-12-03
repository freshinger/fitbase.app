<?php

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedingUser
 */
class FeedingUser
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var \DateTime
     */
    private $date;


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
     * Set count
     *
     * @param integer $count
     * @return FeedingUser
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return FeedingUser
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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return FeedingUser
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
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup
     */
    private $group;


    /**
     * Set group
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup $group
     * @return FeedingUser
     */
    public function setGroup(\Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add items
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser $items
     * @return FeedingUser
     */
    public function addItem(\Fitbase\Bundle\ExerciseBundle\Entity\FeedingUserItem $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser $items
     */
    public function removeItem(\Fitbase\Bundle\ExerciseBundle\Entity\FeedingUserItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
