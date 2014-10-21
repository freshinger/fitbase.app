<?php

namespace Fitbase\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;

class Company
{
    protected $id;
    protected $name;
    protected $description;
    protected $site;
    protected $date;

    protected $logo;
    protected $logoWidth;
    protected $logoHeight;

    protected $colorHeader;
    protected $colorFooter;
    protected $colorBackground;

    protected $questionnaire;
    protected $gamification;

    protected $textEmail;

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
     * @param mixed $questionnaire
     */
    public function setQuestionnaire($questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
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

}