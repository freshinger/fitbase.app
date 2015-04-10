<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 07/04/15
 * Time: 09:47
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class GamificationSettings
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
    private $settingsHasAvatar;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->settingsHasAvatar = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return GamificationSettings
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
     * Add settingsHasAvatar
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasAvatar $settingsHasAvatar
     * @return GamificationSettings
     */
    public function addSettingsHasAvatar(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasAvatar $settingsHasAvatar)
    {
        $settingsHasAvatar->setSettings($this);

        $this->settingsHasAvatar[] = $settingsHasAvatar;

        return $this;
    }

    /**
     * Remove settingsHasAvatar
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasAvatar $settingsHasAvatar
     */
    public function removeSettingsHasAvatar(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasAvatar $settingsHasAvatar)
    {
        $this->settingsHasAvatar->removeElement($settingsHasAvatar);
    }

    /**
     * Get settingsHasAvatar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettingsHasAvatar()
    {
        return $this->settingsHasAvatar;
    }

    /**
     * {@inheritdoc}
     */
    public function setSettingsHasAvatar($settingsHasAvatars)
    {
        $this->settingsHasAvatar = new ArrayCollection();

        foreach ($settingsHasAvatars as $settingsHasAvatar) {
            $this->addSettingsHasAvatar($settingsHasAvatar);
        }
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $settingsHasTree;


    /**
     * Add settingsHasTree
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasTree $settingsHasTree
     * @return GamificationSettings
     */
    public function addSettingsHasTree(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasTree $settingsHasTree)
    {
        $settingsHasTree->setSettings($this);

        $this->settingsHasTree[] = $settingsHasTree;

        return $this;
    }

    /**
     * Remove settingsHasTree
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasTree $settingsHasTree
     */
    public function removeSettingsHasTree(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasTree $settingsHasTree)
    {
        $this->settingsHasTree->removeElement($settingsHasTree);
    }

    /**
     * Get settingsHasTree
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettingsHasTree()
    {
        return $this->settingsHasTree;
    }

    /**
     * Get media object for tree
     * @param null $date
     * @param null $points
     * @return null
     */
    public function getTreeMedia($date = null, $points = null)
    {
        if (($collection = $this->getSettingsHasTree())) {
            foreach ($collection as $id => $hasGallery) {
                if (($gallery = $hasGallery->getGallery())) {

                    if (($dateShow = $hasGallery->getShowAt())) {
                        if (($interval = $hasGallery->getinterval())) {

                            $dateShow->setDate(
                                $date->format('Y'),
                                $dateShow->format('m'),
                                $dateShow->format('d')
                            );

                            if ($dateShow <= $date) {
                                $dateShow->modify("+$interval week");
                                if ($dateShow >= $date) {
                                    return $gallery->getTreeMedia($date, $points);
                                }
                            }
                        }
                    }
                }
            }

            foreach ($collection as $id => $hasGallery) {
                if (($gallery = $hasGallery->getGallery())) {
                    if (!($dateShow = $hasGallery->getShowAt())) {
                        return $gallery->getTreeMedia($date, $points);
                    }
                }
            }

        }
        return null;
    }


    /**
     * {@inheritdoc}
     */
    public function setSettingsHasTree($settingsHasTrees)
    {
        $this->settingsHasTree = new ArrayCollection();

        foreach ($settingsHasTrees as $settingsHasTree) {
            $this->addSettingsHasTree($settingsHasTree);
        }
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $settingsHasBackground;


    /**
     * Add settingsHasBackground
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasBackground $settingsHasBackground
     * @return GamificationSettings
     */
    public function addSettingsHasBackground(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasBackground $settingsHasBackground)
    {
        $settingsHasBackground->setSettings($this);

        $this->settingsHasBackground[] = $settingsHasBackground;

        return $this;
    }

    /**
     * Remove settingsHasBackground
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasBackground $settingsHasBackground
     */
    public function removeSettingsHasBackground(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsHasBackground $settingsHasBackground)
    {
        $this->settingsHasBackground->removeElement($settingsHasBackground);
    }

    /**
     * Get settingsHasBackground
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettingsHasBackground()
    {
        return $this->settingsHasBackground;
    }


    /**
     * {@inheritdoc}
     */
    public function setSettingsHasBackground($settingsHasBackgrounds)
    {
        $this->settingsHasBackground = new ArrayCollection();

        foreach ($settingsHasBackgrounds as $settingsHasBackground) {
            $this->addSettingsHasBackground($settingsHasBackground);
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
