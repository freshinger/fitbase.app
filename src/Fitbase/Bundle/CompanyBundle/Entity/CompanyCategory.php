<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/11/14
 * Time: 12:27
 */

namespace Fitbase\Bundle\CompanyBundle\Entity;


class CompanyCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fitbase\Bundle\CompanyBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Category
     */
    private $category;


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
     * Set company
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\Company $company
     * @return CompanyCategory
     */
    public function setCompany(\Fitbase\Bundle\CompanyBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Fitbase\Bundle\CompanyBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set category
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return CompanyCategory
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
     * Get object name
     * @return mixed|string
     */
    public function __toString()
    {
        if (($category = $this->getCategory())) {
            return (string)$category->getName();
        }
        return "";
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory
     */
    private $parent;

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
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $children
     * @return CompanyCategory
     */
    public function addChild(\Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $children
     */
    public function removeChild(\Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $children)
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
     * Set parent
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $parent
     * @return CompanyCategory
     */
    public function setParent(\Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory
     */
    public function getParent()
    {
        return $this->parent;
    }


    public function getCountUser()
    {
        $count = 0;
        if (($company = $this->getCompany())) {
            if (($users = $company->getUsers())) {
                foreach ($users as $user) {
                    if (($focus = $user->getFocus())) {
                        if (($focusCategory = $focus->getFirstCategory())) {
                            if ($this->getCategory()->getId() == $focusCategory->getCategory()->getId()) {
                                $count++;
                            }
                        }
                    }
                }
            }
        }
        return $count;
    }
}
