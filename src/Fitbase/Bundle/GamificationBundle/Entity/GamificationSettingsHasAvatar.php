<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 12:17
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationSettingsHasAvatar
{

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
     * @return GamificationSettingsHasAvatar
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
     * @return GamificationSettingsHasAvatar
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
     * @return GamificationSettingsHasAvatar
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
     * @var \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar
     */
    private $gallery;


    /**
     * Set gallery
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar $gallery
     * @return GamificationSettingsHasAvatar
     */
    public function setGallery(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar 
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
