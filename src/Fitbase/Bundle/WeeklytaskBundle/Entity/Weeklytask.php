<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/13/14
 * Time: 11:57 AM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


class Weeklytask
{
    protected $id;
    protected $name;
    protected $format;
    protected $content;
    protected $countPoint;
    protected $quiz;
    protected $weekId;
    protected $tag;

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return mixed
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * @param mixed $quiz
     */
    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param mixed $countPoint
     */
    public function setCountPoint($countPoint)
    {
        $this->countPoint = $countPoint;
    }

    /**
     * @return mixed
     */
    public function getCountPoint()
    {
        return $this->countPoint;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param mixed $weekId
     */
    public function setWeekId($weekId)
    {
        $this->weekId = $weekId;
    }

    /**
     * @return mixed
     */
    public function getWeekId()
    {
        return $this->weekId;
    }

    /**
     * Get string from object
     * @return mixed|string
     */
    public function __toString()
    {
        if($this->getId()) {
            return $this->getName();
        }

        return 'Neue Wochenaufgabe';
    }

    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Collection
     */
    protected $collection;

    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Category
     */
    protected $category;


    /**
     * Set collection
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Collection $collection
     * @return Weeklytask
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
     * Set category
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return Weeklytask
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
}
