<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 13:45
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class GamificationSettingsGalleryAvatar
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $galleryHasMedia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleryHasMedia = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return GamificationSettingsGalleryAvatar
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add galleryHasMedia
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatarHasMedia $galleryHasMedia
     * @return GamificationSettingsGalleryAvatar
     */
    public function addGalleryHasMedia(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatarHasMedia $galleryHasMedia)
    {
        $galleryHasMedia->setGallery($this);

        $this->galleryHasMedia[] = $galleryHasMedia;

        return $this;
    }

    /**
     * Remove galleryHasMedia
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatarHasMedia $galleryHasMedia
     */
    public function removeGalleryHasMedia(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatarHasMedia $galleryHasMedia)
    {
        $this->galleryHasMedia->removeElement($galleryHasMedia);
    }

    /**
     * Get galleryHasMedia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGalleryHasMedia()
    {
        return $this->galleryHasMedia;
    }


    /**
     * {@inheritdoc}
     */
    public function setGalleryHasMedia($galleryHasMedias)
    {
        $this->galleryHasMedia = new ArrayCollection();

        foreach ($galleryHasMedias as $galleryHasMedia) {
            $this->addGalleryHasMedia($galleryHasMedia);
        }
    }

    /**
     * Convert object to string
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

}
