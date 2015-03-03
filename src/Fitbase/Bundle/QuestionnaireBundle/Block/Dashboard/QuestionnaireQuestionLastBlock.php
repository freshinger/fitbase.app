<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockService;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserManagerInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class QuestionnaireQuestionLastBlock extends QuestionnaireQuestionBlock
{
    /**
     * get statistic data
     *
     * @param $questionnaireUser
     * @param $question
     * @return array|mixed
     */
    protected function getStatisticsData($questionnaireUser, $question)
    {
        $result = array();
        if (($questionnaire = $questionnaireUser->getQuestionnaire())) {
            if (($user = $this->serviceUser->current())) {
                if (($company = $user->getCompany())) {
                    if (($users = $company->getUsers())) {

                        foreach ($users as $user) {
                            if (($questionnaireUser = $user->getAssessment($questionnaire))) {
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
        return 'Statistic question last (Questionnaire)';
    }
} 