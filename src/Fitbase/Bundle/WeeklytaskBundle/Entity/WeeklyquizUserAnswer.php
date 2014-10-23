<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/13/14
 * Time: 12:11 PM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class WeeklyquizUserAnswer
{
    protected $id;
    protected $quiz;
    protected $user;
    protected $question;
    protected $answerUser;
    protected $answerRight;
    protected $correct;
    protected $countPoint;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answerUser = new ArrayCollection();
        $this->answerRight = new ArrayCollection();
    }

    /**
     * @param mixed $answerRight
     */
    public function setAnswerRight($answerRight)
    {
        if (!is_array($answerRight)) {
            $answerRight = array($answerRight);
        }

        $this->answerRight = $answerRight;
    }

    /**
     * @return mixed
     */
    public function getAnswerRight()
    {
        return $this->answerRight;
    }

    /**
     * @param mixed $answerUser
     */
    public function setAnswerUser($answerUser)
    {
        if (!is_array($answerUser)) {
            $answerUser = array($answerUser);
        }

        $this->answerUser = $answerUser;
    }

    /**
     * @return mixed
     */
    public function getAnswerUser()
    {
        return $this->answerUser;
    }

    /**
     * @param mixed $correct
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }

    /**
     * @return mixed
     */
    public function getCorrect()
    {
        return $this->correct;
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
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
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
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     *
     * @return bool|void
     */
    public function checkCorrect()
    {
        if (($question = $this->getQuestion())) {

            switch ($question->getType()) {
                case 'checkbox':
                    return $this->checkCorrectCheckbox();
                case 'radiobutton':
                    return $this->checkCorrectRadiobutton();
            }
        }
        return false;
    }

    /**
     * Check is answer correct for checkboxes
     * @return bool
     */
    protected function checkCorrectCheckbox()
    {
        if (($collectionUser = $this->getAnswerUser())) {
            if (!$collectionUser instanceof ArrayCollection) {
                $collectionUser = new ArrayCollection($collectionUser);
            }

            if (($collectionRight = $this->getAnswerRight())) {
                if (!$collectionRight instanceof ArrayCollection) {
                    $collectionRight = new ArrayCollection($collectionRight);
                }

                // Check that count of answers equals
                if ($collectionUser->count() == $collectionRight->count()) {
                    // Return true if all answers was found and
                    // false if one ore more not exists
                    return $collectionRight->forAll(function ($key, $answerRight) use ($collectionUser) {
                        // If answer found do loop
                        // if answer not found return false
                        return !$collectionUser->forAll(function ($key, $answerUser) use ($answerRight) {
                            // If user answer not found
                            // do loop till answer have been found
                            if ($answerUser->getId() != $answerRight->getId()) {
                                return true;
                            }
                            // if usr answer exists than
                            // return false to break a loop
                            return false;
                        });
                    });
                }
            }
        }

        return false;
    }

    /**
     * Check is answer correct for radio buttons
     * @return bool
     */
    protected function checkCorrectRadiobutton()
    {
        if (($collectionUser = $this->getAnswerUser())) {
            if (!$collectionUser instanceof ArrayCollection) {
                $collectionUser = new ArrayCollection($collectionUser);
            }
            if (($answer = $collectionUser->get(0))) {
                return $answer->getCorrect();
            }
        }
        return false;
    }


    /**
     * Add answerUser
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerUser
     * @return WeeklyquizUserAnswer
     */
    public function addAnswerUser(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerUser)
    {
        $this->answerUser[] = $answerUser;

        return $this;
    }

    /**
     * Remove answerUser
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerUser
     */
    public function removeAnswerUser(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerUser)
    {
        $this->answerUser->removeElement($answerUser);
    }

    /**
     * Add answerRight
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerRight
     * @return WeeklyquizUserAnswer
     */
    public function addAnswerRight(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerRight)
    {
        $this->answerRight[] = $answerRight;

        return $this;
    }

    /**
     * Remove answerRight
     *
     * @param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerRight
     */
    public function removeAnswerRight(\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer $answerRight)
    {
        $this->answerRight->removeElement($answerRight);
    }
}
