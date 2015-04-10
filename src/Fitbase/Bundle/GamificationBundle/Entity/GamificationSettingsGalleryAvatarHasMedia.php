<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 13:45
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationSettingsGalleryAvatarHasMedia
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar
     */
    private $gallery;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $media;


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
     * Set gallery
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar $gallery
     * @return GamificationSettingsGalleryAvatarHasMedia
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

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return GamificationSettingsGalleryAvatarHasMedia
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
     * Convert object to string
     * @return string
     */
    public function __toString()
    {
        if (($media = $this->getMedia())) {
            return $media->getName();
        }
        return '';
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
     * @return GamificationSettingsGalleryAvatarHasMedia
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
     * @return GamificationSettingsGalleryAvatarHasMedia
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
