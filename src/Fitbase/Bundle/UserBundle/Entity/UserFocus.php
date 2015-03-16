<?php

namespace Fitbase\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserFocus
 */
class UserFocus
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;


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
     * Set name
     *
     * @param string $name
     * @return UserFocus
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
     * @return UserFocus
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UserFocus
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
     * Add categories
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $categories
     * @return UserFocus
     */
    public function addCategory(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Set user focus categories
     * @param array $categories
     * @return $this
     */
    public function setCategories($categories = array())
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $categories
     */
    public function removeCategory(\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get main focus category
     * @return mixed|null
     */
    public function getFirstCategory()
    {
        if (($collection = $this->getParentCategories())) {
            if (($collection = $collection->toArray())) {
                if (($category = array_shift($collection))) {
                    return $category;
                }
            }
        }
        return null;
    }

    /**
     * Get first categories with children
     * @return array
     */
    public function getFirstCategories()
    {
        $collection = array();
        if (($category = $this->getFirstCategory()->getCategory())) {
            $collection = array_merge($collection, $this->getCategoryChildren($category));
        }
        return $collection;
    }

    /**
     * Get category children for each category
     * @param $category
     * @return array
     */
    protected function getCategoryChildren($category)
    {
        $collection = array($category);
        if (($children = $category->getChildren())) {
            foreach ($children as $child) {
                $collection = array_merge($collection, $this->getCategoryChildren($child));
            }
        }
        return $collection;
    }

    /**
     *
     * @param $categories
     */
    public function setParentCategories($categories)
    {
        if (is_array($categories)) {
            $categories = new ArrayCollection($categories);
        }

        if (($parents = $this->getParentCategories())) {
            foreach ($parents as $parent) {

                // Check is current array include
                // all parent categories
                $exist = $categories->exists(function ($index, UserFocusCategory $entity) use ($parent) {
                    if ($entity->getId() == $parent->getId()) {
                        return true;
                    }
                });

                // if not, remove
                // parent category
                if ($exist !== true) {
                    $this->removeCategory($parent);
                }
            }

            // check is parent categories have a
            // given new parent categories
            foreach ($categories as $candidate) {

                $exist = $parents->exists(function ($index, UserFocusCategory $entity) use ($candidate) {
                    if ($entity->getId() == $candidate->getId()) {
                        return true;
                    }
                });

                // if not, add a new
                // category to list
                if ($exist !== true) {
                    $this->addCategory($candidate);
                }
            }
        }
    }

    /**
     * Get collection with parent-only categories
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getParentCategories()
    {
        if (($collection = $this->getCategories())) {
            return $collection->filter(function (\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $entity) {
                if (!$entity->getCategory()->getParent()) {
                    return true;
                }
                return false;
            });
        }
        return null;
    }

    /**
     * Get user focus category by category
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return \Application\Sonata\ClassificationBundle\Entity\Category|mixed|null
     */
    public function getCategory(\Application\Sonata\ClassificationBundle\Entity\Category $category)
    {
        if (($collection = $this->getCategories())) {
            $collection = $collection->filter(function (\Fitbase\Bundle\UserBundle\Entity\UserFocusCategory $entity) use ($category) {
                if ($entity->getCategory()->getId() == $category->getId()) {
                    return true;
                }
                return false;
            });
            if (($collection = $collection->toArray())) {
                if (($category = array_shift($collection))) {
                    return $category;
                }
            }
        }
        return null;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->getUser()}";
    }

    /**
     * @var boolean
     */
    private $update;


    /**
     * Set update
     *
     * @param boolean $update
     * @return UserFocus
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
