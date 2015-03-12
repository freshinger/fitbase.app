<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\QuestionnaireBundle\Block;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class QuestionnaireQuestionBlock extends SecureBlockServiceAbstract
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'question' => null,
            'questionnaireUser' => null,
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/questionnaire_question.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $statistics = array();
        if (($question = $blockContext->getSetting('question'))) {
            if (($questionnaireUser = $blockContext->getSetting('questionnaireUser'))) {
                $statistics = $this->getStatistics($questionnaireUser, $question);
            }
        }

//        "#a2d049", "#d1de3f", "#fce14b", "#f08e3e", "#e65a3b", "#d7ecaf", "#397bc9", "#7eaae0", "#bfd6f3", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'question' => $question,
            'statistics' => $statistics
        ));
    }

    /**
     * Get statistics
     * @param $questionnaireUser
     * @param $question
     * @return array
     */
    protected function getStatistics($questionnaireUser, $question)
    {
        $statistics = array();
        if (($answers = $question->getAnswers())) {
            foreach ($answers as $answer) {
                $statistics[$answer->getName()] = 0;
            }

            if (($userAnswers = $this->getStatisticsData($questionnaireUser, $question))) {
                foreach ($userAnswers as $userAnswer) {
                    if (($answers = $userAnswer->getAnswers())) {
                        foreach ($answers as $answer) {
                            if (!array_key_exists($answer->getName(), $statistics)) {
                                $statistics[$answer->getName()] = 0;
                            }
                            $statistics[$answer->getName()]++;
                        }
                    }
                }
            }

            if (array_sum($statistics) <= 0) {
                foreach ($answers as $answer) {
                    $statistics[$answer->getName()] = 1;
                }
            }
        }

        return $statistics;
    }


    /**
     * Get statistical data
     * @param $questionnaireUser
     * @param $question
     * @return array
     */
    protected function getStatisticsData($questionnaireUser, $question)
    {
        $result = array();
        if (($questionnaireCompany = $questionnaireUser->getSlice())) {
            if (($user = $questionnaireUser->getUser())) {
                if (($company = $user->getCompany())) {
                    if (($users = $company->getUsers())) {
                        foreach ($users as $user) {

                            if (($questionnaireUser = $user->getQuestionnaireSlice($questionnaireCompany))) {
                                if (($answers = $questionnaireUser->getAnswers($question))) {
                                    $result = array_merge($result, $answers->toArray());
                                }
                            }
                        }
                    }
                }
            }

            return $result;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Statistic question (Questionnaire)';
    }
} 