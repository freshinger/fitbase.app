<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 13:50
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationSettingsGalleryTreeHasMedia
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryTree
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
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryTree $gallery
     * @return GamificationSettingsGalleryTreeHasMedia
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
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return GamificationSettingsGalleryTreeHasMedia
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
     * @var integer
     */
    private $countPoint;


    /**
     * Set countPoint
     *
     * @param integer $countPoint
     * @return GamificationSettingsGalleryTreeHasMedia
     */
    public function setCountPoint($countPoint)
    {
        $this->countPoint = $countPoint;

        return $this;
    }

    /**
     * Get countPoint
     *
     * @return integer 
     */
    public function getCountPoint()
    {
        return $this->countPoint;
    }
}
