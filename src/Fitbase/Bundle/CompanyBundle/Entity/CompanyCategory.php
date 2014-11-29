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
        $string = "";

        if (($company = $this->getCompany())) {
            $string .= (string)$company->getName();
            if (($category = $this->getCategory())) {
                $string .= ': ' . (string)$category->getName();
            }
        }

        return $string;
    }
}
