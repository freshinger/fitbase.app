<?php

namespace Fitbase\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFocusCategory
 */
class UserFocusCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $priority;


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
     * Set priority
     *
     * @param integer $priority
     * @return UserFocusCategory
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @var \Fitbase\Bundle\UserBundle\Entity\UserFocus
     */
    private $focus;

    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Category
     */
    private $category;


    /**
     * Set focus
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocus $focus
     * @return UserFocusCategory
     */
    public function setFocus(\Fitbase\Bundle\UserBundle\Entity\UserFocus $focus = null)
    {
        $this->focus = $focus;

        return $this;
    }

    /**
     * Get focus
     *
     * @return \Fitbase\Bundle\UserBundle\Entity\UserFocus
     */
    public function getFocus()
    {
        return $this->focus;
    }

    /**
     * Set category
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return UserFocusCategory
     */
    public function setCategory(\Application\Sonata\ClassificationBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Application\Sonata\ClassificationBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->getFocus()}: {$this->getCategory()}";
    }

    /**
     * @var \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory
     */
    private $parent;


    /**
     * Set parent
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $parent
     * @return UserFocusCategory
     */
    public function setParent(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add children
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $children
     * @return UserFocusCategory
     */
    public function addChild(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $children
     */
    public function removeChild(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
