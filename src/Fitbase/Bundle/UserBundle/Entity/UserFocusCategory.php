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
        return "{$this->getCategory()}";
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

    /**
     * @var integer
     */
    private $type;


    /**
     * Set type
     *
     * @param integer $type
     * @return UserFocusCategory
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $primaries;


    /**
     * Add primaries
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $primaries
     * @return UserFocusCategory
     */
    public function addPrimary(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $primaries)
    {
        $this->primaries[] = $primaries;

        return $this;
    }

    /**
     * Remove primaries
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $primaries
     */
    public function removePrimary(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $primaries)
    {
        $this->primaries->removeElement($primaries);
    }

    /**
     * Get primaries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrimaries()
    {
        return $this->primaries;
    }
    /**
     * @var \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory
     */
    private $primary;


    /**
     * Set primary
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $primary
     * @return UserFocusCategory
     */
    public function setPrimary(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $primary = null)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * Get primary
     *
     * @return \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory 
     */
    public function getPrimary()
    {
        return $this->primary;
    }
    /**
     * @var boolean
     */
    private $update;


    /**
     * Set update
     *
     * @param boolean $update
     * @return UserFocusCategory
     */
    public function setUpdate($update)
    {
        $this->update = $update;

        return $this;
    }

    /**
     * Get update
     *
     * @return boolean 
     */
    public function getUpdate()
    {
        return $this->update;
    }
}
