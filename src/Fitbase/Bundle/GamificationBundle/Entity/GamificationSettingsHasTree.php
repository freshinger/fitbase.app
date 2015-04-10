<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 12:17
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationSettingsHasTree {

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettings
     */
    private $settings;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $media;


    /**
     * Set description
     *
     * @param string $description
     * @return GamificationSettingsHasTree
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set settings
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettings $settings
     * @return GamificationSettingsHasTree
     */
    public function setSettings(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettings $settings = null)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettings 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return GamificationSettingsHasTree
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Object to string
     * @return null|string
     */
    public function __toString()
    {
        if (($media = $this->getMedia())) {
            return $media->getName();
        }
        return '';
    }
    /**
     * @var \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryTree
     */
    private $gallery;


    /**
     * Set gallery
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryTree $gallery
     * @return GamificationSettingsHasTree
     */
    public function setGallery(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryTree $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryTree 
     */
    public function getGallery()
    {
        return $this->gallery;
    }
    /**
     * @var \DateTime
     */
    private $showAt;

    /**
     * @var integer
     */
    private $interval;


    /**
     * Set showAt
     *
     * @param \DateTime $showAt
     * @return GamificationSettingsHasTree
     */
    public function setShowAt($showAt)
    {
        $this->showAt = $showAt;

        return $this;
    }

    /**
     * Get showAt
     *
     * @return \DateTime 
     */
    public function getShowAt()
    {
        return $this->showAt;
    }

    /**
     * Set interval
     *
     * @param integer $interval
     * @return GamificationSettingsHasTree
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Get interval
     *
     * @return integer 
     */
    public function getInterval()
    {
        return $this->interval;
    }
}
