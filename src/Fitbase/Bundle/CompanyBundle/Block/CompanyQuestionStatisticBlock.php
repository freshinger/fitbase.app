<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


use Fitbase\Bundle\CompanyBundle\Block\Dashboard\AbstractStatisticLimitedBlock;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CompanyQuestionStatisticBlock extends CompanyUserLimitedBlockAbstract
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
            'template_default' => 'FitbaseCompanyBundle:Block:questionnaire_question.html.twig',
            'template_locked' => 'FitbaseCompanyBundle:Block:questionnaire_question_locked.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $statistics = array();
        if (($question = $blockContext->getSetting('question'))) {
            if (($questionnaireUser = $blockContext->getSetting('questionnaireUser'))) {
                $statistics = $this->getStatistics($questionnaireUser, $question);
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template_default'), array(
            'question' => $question,
            'statistics' => $statistics
        ));
    }

    public function lock(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderPrivateResponse($blockContext->getSetting('template_locked'), array());
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
                $statistic = new \stdClass();
                $statistic->color = $answer->getColor();
                $statistic->name = $answer->getName();
                $statistic->value = 0;

                $statistics[$answer->getId()] = $statistic;
            }

            $total = 0;
            if (($userAnswers = $this->getStatisticsData($questionnaireUser, $question))) {
                foreach ($userAnswers as $userAnswer) {
                    if (($answers = $userAnswer->getAnswers())) {
                        foreach ($answers as $answer) {
                            if (!array_key_exists($answer->getId(), $statistics)) {

                                $statistic = new \stdClass();
                                $statistic->color = $answer->getColor();
                                $statistic->name = $answer->getName();
                                $statistic->value = 0;

                                $statistics[$answer->getId()] = $statistic;
                            }

                            if ($statistics[$answer->getId()] instanceof \stdClass) {
                                $total++;
                                $statistics[$answer->getId()]->value++;
                            }
                        }
                    }
                }
            }


            if ($total <= 0) {
                return null;
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