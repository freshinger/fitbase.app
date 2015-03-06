<?php

namespace Fitbase\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;

class Company
{
    protected $id;
    protected $name;
    protected $description;
    protected $url;
    protected $site;
    protected $date;

    protected $logo;
    protected $logoWidth;
    protected $logoHeight;

    protected $colorHeader;
    protected $colorFooter;
    protected $colorBackground;

    protected $gamification;

    protected $textEmail;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param mixed $gamification
     */
    public function setGamification($gamification)
    {
        $this->gamification = $gamification;
    }

    /**
     * @return mixed
     */
    public function getGamification()
    {
        return $this->gamification;
    }

    /**
     * @param mixed $textEmail
     */
    public function setTextEmail($textEmail)
    {
        $this->textEmail = $textEmail;
    }

    /**
     * @return mixed
     */
    public function getTextEmail()
    {
        return $this->textEmail;
    }

    /**
     * @param mixed $colorBackground
     */
    public function setColorBackground($colorBackground)
    {
        $this->colorBackground = $colorBackground;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColorBackground()
    {
        return $this->colorBackground;
    }

    /**
     * @param mixed $colorFooter
     */
    public function setColorFooter($colorFooter)
    {
        $this->colorFooter = $colorFooter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColorFooter()
    {
        return $this->colorFooter;
    }

    /**
     * @param mixed $colorHeader
     */
    public function setColorHeader($colorHeader)
    {
        $this->colorHeader = $colorHeader;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColorHeader()
    {
        return $this->colorHeader;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logoHeight
     */
    public function setLogoHeight($logoHeight)
    {
        $this->logoHeight = $logoHeight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogoHeight()
    {
        return $this->logoHeight;
    }

    /**
     * @param mixed $logoWidth
     */
    public function setLogoWidth($logoWidth)
    {
        $this->logoWidth = $logoWidth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogoWidth()
    {
        return $this->logoWidth;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Convert object to string
     * @return string
     */
    public function __toString()
    {
        return implode(' ', array(
            $this->getId(),
            $this->getName(),
        ));
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categories
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $categories
     * @return Company
     */
    public function addCategory(\Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $categories
     */
    public function removeCategory(\Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $categories)
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
     * Get collection with parent-only categories
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getParentCategories()
    {
        if (($collection = $this->getCategories())) {
            return $collection->filter(function ($entity) {
                if (!$entity->getCategory()->getParent()) {
                    return true;
                }
                return false;
            });
        }
        return null;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getChildCategories()
    {
        if (($collection = $this->getCategories())) {
            return $collection->filter(function ($entity) {
                if ($entity->getCategory()->getParent()) {
                    return true;
                }
                return false;
            });
        }
        return null;
    }

    /**
     * Get CompanyCategory by slug
     * @param $slug
     * @return mixed|null
     */
    public function getCategoryBySlug($slug)
    {
        if (($collection = $this->getCategories())) {
            foreach ($collection as $companyCategory) {
                if (($category = $companyCategory->getCategory())) {
                    if ($category->getSlug() == $slug) {
                        return $companyCategory;
                    }
                }
            }
        }
        return null;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;


    /**
     * Add users
     *
     * @param \Application\Sonata\UserBundle\Entity\User $users
     * @return Company
     */
    public function addUser(\Application\Sonata\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Application\Sonata\UserBundle\Entity\User $users
     */
    public function removeUser(\Application\Sonata\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $image;


    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Company
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $footer;

    /**
     * @var string
     */
    private $background1;

    /**
     * @var string
     */
    private $background2;

    /**
     * @var string
     */
    private $background3;


    /**
     * Set header
     *
     * @param string $header
     * @return Company
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set footer
     *
     * @param string $footer
     * @return Company
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set background1
     *
     * @param string $background1
     * @return Company
     */
    public function setBackground1($background1)
    {
        $this->background1 = $background1;

        return $this;
    }

    /**
     * Get background1
     *
     * @return string
     */
    public function getBackground1()
    {
        return $this->background1;
    }

    /**
     * Set background2
     *
     * @param string $background2
     * @return Company
     */
    public function setBackground2($background2)
    {
        $this->background2 = $background2;

        return $this;
    }

    /**
     * Get background2
     *
     * @return string
     */
    public function getBackground2()
    {
        return $this->background2;
    }

    /**
     * Set background3
     *
     * @param string $background3
     * @return Company
     */
    public function setBackground3($background3)
    {
        $this->background3 = $background3;

        return $this;
    }

    /**
     * Get background3
     *
     * @return string
     */
    public function getBackground3()
    {
        return $this->background3;
    }

    /**
     * @var string
     */
    private $slug;


    /**
     * Set slug
     *
     * @param string $slug
     * @return Company
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $actioncodes;


    /**
     * Add actioncodes
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserActioncode $actioncodes
     * @return Company
     */
    public function addActioncode(\Fitbase\Bundle\UserBundle\Entity\UserActioncode $actioncodes)
    {
        $this->actioncodes[] = $actioncodes;

        return $this;
    }

    /**
     * Remove actioncodes
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserActioncode $actioncodes
     */
    public function removeActioncode(\Fitbase\Bundle\UserBundle\Entity\UserActioncode $actioncodes)
    {
        $this->actioncodes->removeElement($actioncodes);
    }

    /**
     * Get actioncodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActioncodes()
    {
        return $this->actioncodes;
    }

    /**
     * @var \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire
     */
    private $questionnaire;


    /**
     * Set questionnaire
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire $questionnaire
     * @return Company
     */
    public function setQuestionnaire(\Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return \Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }
}
