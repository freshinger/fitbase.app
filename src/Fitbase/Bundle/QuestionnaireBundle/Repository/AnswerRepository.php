<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:37 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AnswerRepository extends EntityRepository
{
    protected function getAnswerPercentageString($answerId, $questionId)
    {
        switch ($questionId) {
            case 1:
                $hashmap = array(
                    2 => 10,
                    3 => 5,
                    5 => -5,
                    6 => -10,
                );
                if (isset($hashmap[$answerId])) {
                    return $hashmap[$answerId];
                }
                return 0;
            case 2:
                if ($answerId == 7) {
                    return 0;
                }
                return -10;
            case 3:
                if ($answerId == 15) {
                    return -10;
                }
                return 0;
            case 4:
                if ($answerId == 17) {
                    return -10;
                }
                return 0;
            case 5:
                switch ($answerId) {
                    case 19:
                        return 5;
                    case 23:
                    case 24:
                    case 25:
                    case 26:
                        return -5;
                    case 27:
                    case 28:
                    case 29:
                        return -10;
                }
                return 0;
            case 6:
                if ($answerId > 10) {
                    return -10;
                }
                if ($answerId > 5) {
                    return -5;
                }
                return 0;
            case 7:
                return 0;
            case 8:
                if ($answerId < 20 or $answerId >= 26) {
                    return -10;
                }
                return 10;
            case 9:
            case 10:
            case 11:
            case 12:
            case 15:
                if (($answer = $this->findOneBy(array('id' => $answerId)))) {
                    $value = absint($answer->getText());
                    if ($questionId == 15) {
                        $value = ($value - 5) * -1;
                    }
                    switch ($value) {
                        case 0:
                            return 10;
                        case 1:
                            return 5;
                        case 4:
                            return -5;
                        case 5:
                            return -10;
                    }
                }
                return 0;
            case 13:
            case 14:
                if (($answer = $this->findOneBy(array('id' => $answerId)))) {
                    $value = absint($answer->getText());
                    if ($questionId == 13) {
                        return $value * 5;
                    } else if ($questionId == 13) {
                        return -($value - 6) * 5;
                    }
                }
                return 0;
        }
        return 0;
    }

    /**
     * Get percentage for each answer
     * @param $answer
     * @param $questionId
     * @return int|void
     */
    public function getAnswerPercentage($answer, $questionId)
    {
        if (is_array($answer)) {
            $percentage = 0;
            foreach ($answer as $answerString) {
                $percentage += $this->getAnswerPercentageString(str_replace('answer_', '', $answerString), $questionId);
            }
            return $percentage;
        } else {
            return $this->getAnswerPercentageString(str_replace('answer_', '', $answer), $questionId);
        }
    }


    /**
     * Get answers als choice list
     * @param $question
     * @return array
     */
    public function getAnswerListChoice($question)
    {
        $answers = $this->findBy(array('questionId' => $question->getId()));

        $choices = array();
        if (count($answers)) {
            foreach ($answers as $answer) {
                $choices[$answer->getId()] = $answer->getText();
            }
        }
        return $choices;
    }

} 