<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/13/14
 * Time: 12:06 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Weeklyquiz
{
    protected $id;
    protected $name;
    protected $description;
    protected $countPoint;
    protected $task;
    protected $format;
    protected $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection(array());
    }

    /**
     * Add answer to collection
     * @param $answer
     */
    public function addWeeklyquizQuestion(WeeklyquizQuestion $questions)
    {
        $this->questions[] = $questions;
    }

    /**
     * @return mixed
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param mixed $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
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
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param mixed $task
     */
    public function setTask($task)
    {
        $this->task = $task;
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
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param mixed $weeklytaskId
     */
    public function setWeeklytaskId($weeklytaskId)
    {
        $this->weeklytaskId = $weeklytaskId;
    }

    /**
     * @return mixed
     */
    public function getWeeklytaskId()
    {
        return $this->weeklytaskId;
    }

    /**
     * Convert object to string
     * @return mixed
     */
    public function __toString()
    {
        if ($this->getId()) {
            return $this->getName();
        }
        return "Neu Quiz";
    }


    /**
     * Add questions
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion $questions
     * @return Weeklyquiz
     */
    public function addQuestion(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion $questions
     */
    public function removeQuestion(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion $questions)
    {
        $this->questions->removeElement($questions);
    }
}
