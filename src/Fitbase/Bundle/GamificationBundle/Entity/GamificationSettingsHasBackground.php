<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 12:18
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationSettingsHasBackground {

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
     * @return GamificationSettingsHasBackground
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
     * @return GamificationSettingsHasBackground
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
     * @return GamificationSettingsHasBackground
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
}
