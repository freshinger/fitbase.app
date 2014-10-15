<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/13/14
 * Time: 12:11 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


class WeeklyquizAnswer
{

    protected $id;
    protected $quiz;
    protected $quizId;
    protected $question;
    protected $questionId;
    protected $name;
    protected $description;
    protected $correct;


    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;
    }


    public function getQuiz()
    {
        return $this->quiz;
    }


    public function setQuestion($question)
    {
        $this->question = $question;
    }


    public function getQuestion()
    {
        return $this->question;
    }


    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }


    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }


    public function getQuestionId()
    {
        return $this->questionId;
    }


    public function setQuizId($quizId)
    {
        $this->quizId = $quizId;
    }


    public function getQuizId()
    {
        return $this->quizId;
    }


    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }


    public function getCorrect()
    {
        return $this->correct;
    }

    public function __toString()
    {
        return $this->getName();
    }


} 