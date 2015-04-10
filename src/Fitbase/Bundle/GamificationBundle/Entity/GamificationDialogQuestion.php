<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/17/14
 * Time: 10:29 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationDialogQuestion
{
    protected $id;
    protected $questionTrue;
    protected $questionFalse;
    protected $text;
    protected $type;
    protected $start;
    protected $description;
    protected $positive;

    /**
     * @param mixed $positive
     */
    public function setPositive($positive)
    {
        $this->positive = $positive;
    }

    /**
     * @return mixed
     */
    public function getPositive()
    {
        return (boolean)$this->positive;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return (boolean)$this->start;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @param mixed $questionFalse
     */
    public function setQuestionFalse($questionFalse)
    {
        $this->questionFalse = $questionFalse;
    }

    /**
     * @return mixed
     */
    public function getQuestionFalse()
    {
        return $this->questionFalse;
    }

    /**
     * @param mixed $questionTrue
     */
    public function setQuestionTrue($questionTrue)
    {
        $this->questionTrue = $questionTrue;
    }

    /**
     * @return mixed
     */
    public function getQuestionTrue()
    {
        return $this->questionTrue;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    public function __toString()
    {
        return $this->getText();
    }
}
