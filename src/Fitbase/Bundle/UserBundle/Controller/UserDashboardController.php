<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\QuestionnaireBundle\Entity\Focus;
use Fitbase\Bundle\QuestionnaireBundle\Form\FocusForm;
use Fitbase\Bundle\UserBundle\Entity\UserPassword;
use Fitbase\Bundle\UserBundle\Entity\UserSearch;
use Fitbase\Bundle\UserBundle\Event\UserPasswordEvent;
use Fitbase\Bundle\UserBundle\Entity\UserProfile;
use Fitbase\Bundle\UserBundle\Event\UserPauseEvent;
use Fitbase\Bundle\UserBundle\Event\UserProfileEvent;
use Fitbase\Bundle\UserBundle\Form\PasswordForm;
use Fitbase\Bundle\UserBundle\Form\UserPauseForm;
use Fitbase\Bundle\UserBundle\Form\UserProfileForm;
use Fitbase\Bundle\UserBundle\Form\UserSearchForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Tests\Controller;


class UserDashboardController extends Controller
{
    /**
     * Display form to change user focus
     * @param Request $request
     * @return Response
     */
    public function optionAction(Request $request)
    {

        if (($user = $this->get('user')->current())) {

            return $this->render('FitbaseUserBundle:Dashboard:option.html.twig', array(
                'eye' => $user->getMetaValue('user_exercise_eye'),
                'rsi' => $user->getMetaValue('user_exercise_rsi'),
                'thera' => $user->getMetaValue('user_exercise_thera'),
                'focus' => $user->getMetaValue('user_exercise_focus'),
            ));
        }
    }

    /**
     * Display button to start current exercise
     * @param Request $request
     * @return Response
     */
    public function exerciseAction(Request $request)
    {
        return $this->render('FitbaseUserBundle:Dashboard:exercise.html.twig');
    }

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticCompanyAction(Request $request)
    {

        $countWeeklytask = 0;
        $countWeeklytaskUser = 0;

        $countWeeklyquiz = 0;
        $countWeeklyquizUser = 0;

        $countQuestionnaire = 0;
        $countQuestionnaireUser = 0;

        if (($user = $this->get('user')->current())) {

            if (($companyId = $user->getMetaValue('user_company_id'))) {

                $managerEntity = $this->get('entity_manager');
                $repositoryCompany = $managerEntity->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

                if (($company = $repositoryCompany->find($companyId))) {

                    $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\Weeklytask');
                    $repositoryWeeklytaskUser = $managerEntity->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskUser');

                    $countWeeklytask = $repositoryWeeklytask->findCount();
                    $countWeeklytaskUser = $repositoryWeeklytaskUser->findCountByCompany($company);

                    $repositoryWeeklytaskQuiz = $managerEntity->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskQuiz');
                    $repositoryWeeklytaskQuizUser = $managerEntity->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskUserQuiz');

                    $countWeeklyquiz = $repositoryWeeklytaskQuiz->findCount();
                    $countWeeklyquizUser = $repositoryWeeklytaskQuizUser->findCountByCompany($company);

                    $repositoryQuestionnaire = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');
                    $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');

                    $countQuestionnaire = $repositoryQuestionnaire->findCount();
                    $countQuestionnaireUser = $repositoryQuestionnaireUser->findCountByCompany($company);
                }
            }
        }

        return $this->render('FitbaseUserBundle:Dashboard:statistic.html.twig', array(
            'weeklytasks' => round((($countWeeklytaskUser * 100) / $countWeeklytask)),
            'weeklyquiz' => round((($countWeeklyquizUser * 100) / $countWeeklyquiz)),
            'questionnaire' => round((($countQuestionnaireUser * 100) / $countQuestionnaire)),
        ));
    }

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticPointAction(Request $request)
    {

        if (($user = $this->get('user')->current())) {

            if (($companyId = $user->getMetaValue('user_company_id'))) {

                $managerEntity = $this->get('entity_manager');
                $repositoryCompany = $managerEntity->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

                if (($company = $repositoryCompany->find($companyId))) {

                    $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\Weeklytask');
                    $repositoryWeeklytaskUser = $managerEntity->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskUser');

                }
            }
        }

        return $this->render('FitbaseUserBundle:Dashboard:statistic_point.html.twig', array());
    }

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticVideoAction(Request $request)
    {
        $statistic = array();

        if (($user = $this->get('user')->current())) {

//            if (($companyId = $user->getMetaValue('user_company_id')))
            {
                $companyId = 5;


                $managerEntity = $this->get('entity_manager');
                $repositoryCompany = $managerEntity->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

                if (($company = $repositoryCompany->find($companyId))) {

                    $repositoryUserStatisticExercise = $managerEntity->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticExercise');

                    if (($statistic = $repositoryUserStatisticExercise->findCountByCompanyForDate($company))) {

                        foreach ($statistic as $index => $element) {
                            $statistic[$index]['date'] = $this->get('datetime')->getDateTime($element['date']);
                            if (isset($statistic[$index + 1])) {
                                $statistic[$index + 1]['count'] += $statistic[$index]['count'];
                            }
                        }
                    }
                }
            }
        }

        return $this->render('FitbaseUserBundle:Dashboard:statistic_video.html.twig', array(
            'statistic' => $statistic
        ));
    }

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticQuestionnaireAction(Request $request)
    {
        $healthCommon = 0;
        $strainCommon = 0;

        if (($user = $this->get('user')->current())) {

            if (($companyId = $user->getMetaValue('user_company_id'))) {

                $repositoryCompany = $this->get('entity_manager')
                    ->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

                if (($company = $repositoryCompany->find($companyId))) {

                    $repositoryQuestionnaireUser = $this->get('entity_manager')
                        ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');

                    $collection = $repositoryQuestionnaireUser->findAllByCompany($company);

                    foreach ($collection as $questionnaireUser) {
                        $healthCommon += $questionnaireUser->getCountPointHealth();
                        $strainCommon += $questionnaireUser->getCountPointStrain();
                    }
                    $healthCommon = $healthCommon / count($collection);
                    $strainCommon = $strainCommon / count($collection);
                }
            }
        }

        return $this->render('FitbaseUserBundle:Dashboard:statistic_questionnaire.html.twig', array(
            'health' => $healthCommon,
            'strain' => $strainCommon,
        ));
    }

}
