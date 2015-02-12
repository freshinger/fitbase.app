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
        return $this;
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
        if ($this->getId()) {
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

    /**
     * @var integer
     */
    private $priority;


    /**
     * Set priority
     *
     * @param integer $priority
     * @return Weeklytask
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
     * @var \Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask
     */
    private $userTask;


    /**
     * Set userTasks
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask $userTasks
     * @return Weeklytask
     */
    public function setUserTask(\Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask $userTask = null)
    {
        $this->userTask = $userTask;

        return $this;
    }

    /**
     * Get userTasks
     *
     * @return \Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask
     */
    public function getUserTask()
    {
        return $this->userTask;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userTask = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userTask
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $userTask
     * @return Weeklytask
     */
    public function addUserTask(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $userTask)
    {
        $this->userTask[] = $userTask;

        return $this;
    }

    /**
     * Remove userTask
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $userTask
     */
    public function removeUserTask(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser $userTask)
    {
        $this->userTask->removeElement($userTask);
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;


    /**
     * Add categories
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     * @return Weeklytask
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
}
