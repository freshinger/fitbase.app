<?php

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedingUserItem
 */
class FeedingUserItem
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
     * @return FeedingUserItem
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
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup
     */
    private $group;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup
     */
    private $feeding;


    /**
     * Set group
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup $group
     * @return FeedingUserItem
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
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return FeedingUserItem
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
     * Set feeding
     *
     * @param \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup $feeding
     * @return FeedingUserItem
     */
    public function setFeeding(\Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser $feeding = null)
    {
        $this->feeding = $feeding;

        return $this;
    }

    /**
     * Get feeding
     *
     * @return \Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup
     */
    public function getFeeding()
    {
        return $this->feeding;
    }
}
