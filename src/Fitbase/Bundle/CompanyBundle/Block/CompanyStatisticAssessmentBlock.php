<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


class CompanyStatisticAssessmentBlock extends CompanyStatisticQuestionBlock implements CompanyBlockInterface
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
            if (($user = $questionnaireUser->getUser())) {
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