<?php

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise
 */
class Exercise
{
    const MOBILISATION = 1;
    const KRAEFTIGUNG = 2;
    const DAEHNUNG = 3;

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $format;

    /**
     * @var integer
     */
    private $countPoint;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $mp4;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $webm;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $image;


    /**
     * Set name
     *
     * @param string $name
     * @return Exercise
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
     * Set description
     *
     * @param string $description
     * @return Exercise
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
     * Set tag
     *
     * @param string $tag
     * @return Exercise
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set format
     *
     * @param string $format
     * @return Exercise
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set countPoint
     *
     * @param integer $countPoint
     * @return Exercise
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
     * Set video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $webm
     * @return Exercise
     */
    public function setWebm(\Application\Sonata\MediaBundle\Entity\Media $webm = null)
    {
        $this->webm = $webm;

        return $this;
    }

    /**
     * Get video
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getWebm()
    {
        return $this->webm;
    }

    /**
     * Set video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $mp4
     * @return Exercise
     */
    public function setMp4(\Application\Sonata\MediaBundle\Entity\Media $mp4 = null)
    {
        $this->mp4 = $mp4;

        return $this;
    }

    /**
     * Get video
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMp4()
    {
        return $this->mp4;
    }

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Exercise
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
     * @var \Application\Sonata\MediaBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Set gallery
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return Exercise
     */
    public function setGallery(\Application\Sonata\MediaBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Category
     */
    private $category;


    /**
     * Set category
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return Exercise
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
     * @var \Application\Sonata\ClassificationBundle\Entity\Collection
     */
    private $collection;


    /**
     * Set collection
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Collection $collection
     * @return Exercise
     */
    public function setCollection(\Application\Sonata\ClassificationBundle\Entity\Collection $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \Application\Sonata\ClassificationBundle\Entity\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @var integer
     */
    private $priority;


    /**
     * Set priority
     *
     * @param integer $priority
     * @return Exercise
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
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
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     * @return Exercise
     */
    public function addCategory(\Application\Sonata\ClassificationBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     */
    public function removeCategory(\Application\Sonata\ClassificationBundle\Entity\Category $categories)
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
     * @var integer
     */
    private $type;


    /**
     * Set type
     *
     * @param integer $type
     * @return Exercise
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}
