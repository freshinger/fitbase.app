<?php

namespace Fitbase\Bundle\GamificationBundle\Controller;

use Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEmotionEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerBooleanForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerFeedbackForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerFinishForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerHiddenForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerNoticeForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTextForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerAbstractForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTrashForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserEmotionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DashboardController extends GamificationCompanyController
{
    /**
     * Displau point statistic for user
     * @param Request $request
     * @return Response
     */
    public function statisticAction(Request $request)
    {
        $statistic = array(
            array(
                'date' => new \DateTime(),
                'count_point_total' => 0,
            )
        );

        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $managerEntity = $this->container->get('fitbase_entity_manager');
            $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

            $datetime = $this->get('datetime')->getDateTime('now');
            $datetime->modify('-12 week');

            $statistic = $repositoryGamificationUserPointlog->findAllByUserGroupByWeek($user, $datetime);
        }

        if (count($statistic)) {
            foreach ($statistic as $index => $element) {
                $statistic[$index]['date'] = $this->get('datetime')->getDateTime($element['date']);
            }
        }

        return $this->render('FitbaseGamificationBundle:Dashboard:statistic.html.twig', array(
            'statistic' => $statistic
        ));
    }

    /**
     * Display user chat with avatar
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function chatAction(Request $request)
    {
        $gamification = null;

        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            $managerEntity = $this->container->get('fitbase_entity_manager');

            $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

            $gamification = $repositoryGamificationUser->findOneByUser($user);
        }

        $percent = 0;

        $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');
        if (($GamificationUserPointlog = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
            $percent = $this->get('gamification')->getPointPercent($GamificationUserPointlog->getCountPoint());
        }

        return $this->render('FitbaseGamificationBundle:Dashboard:chat.html.twig', array(
            'user' => $user,
            'percent' => $percent,
            'gamification' => $gamification,
        ));
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    protected function avatarAction(Request $request)
    {
        $avatar = null;
        $gamification = null;

        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            $managerEntity = $this->container->get('fitbase_entity_manager');
            $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

            if (($gamification = $repositoryGamificationUser->findOneByUser($user))) {
                $avatar = $this->get('gamification')->getSvgAvatar($gamification);
            }
        }

        return $this->render('FitbaseGamificationBundle:Dashboard:avatar.html.twig', array(
            'avatar' => $avatar,
            'gamification' => $gamification,
        ));
    }

    /**
     * Display tree with activity statistic for user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function treeAction(Request $request)
    {
        $tree = null;
        $points = null;
        $gamification = null;

        $managerEntity = $this->container->get('fitbase_entity_manager');
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

            if (($gamification = $repositoryGamificationUser->findOneByUser($user))) {
                $tree = $this->get('gamification')->getSvgTree($gamification);
                $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');
                if (($gamificationUserPointlog = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
                    $points = $gamificationUserPointlog->getCountPointTotal();
                }
            }
        }

        return $this->render('FitbaseGamificationBundle:Dashboard:tree.html.twig', array(
            'tree' => $tree,
            'points' => $points,
            'gamification' => $gamification,
        ));
    }

    /**
     * Display image with activity statistic from all users
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function forestAction(Request $request)
    {
        $company = null;
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $managerEntity = $this->container->get('fitbase_entity_manager');
            $repositoryCompany = $managerEntity->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

            if (($companyId = $user->getMetaValue('user_company_id'))) {
                $company = $repositoryCompany->find($companyId);
            }
        }

        $countPointlogPoint = 0;
        if (is_object($company)) {
            $repositoryUserMeta = $managerEntity->getRepository('Ekino\WordpressBundle\Entity\UserMeta');
            $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

            $collectionUserMeta = $repositoryUserMeta->findBy(array(
                'key' => 'user_company_id',
                'value' => $company->getId(),
            ));

            $collectionUser = array();
            foreach ($collectionUserMeta as $userMeta) {
                array_push($collectionUser, $userMeta->getUser());
            }

            $countPointlogPoint = 0;
            $collectionGamificationUserPointlog = $repositoryGamificationUserPointlog->findAllByUserIdArray($collectionUser);
            foreach ($collectionGamificationUserPointlog as $pointlog) {
                $countPointlogPoint += $pointlog->getCountPointTotal();
            }
        }

        return $this->render('FitbaseGamificationBundle:Dashboard:forest.html.twig', array(
            'forest' => $this->get('gamification')->getSvgForest(),
            'company' => $company,
            'points' => $countPointlogPoint,
        ));
    }

    /**
     * Get next question for answer
     * @param GamificationUserDialogAnswer $answer
     * @return null
     */
    protected function getQuestionNext(GamificationUserDialogAnswer $answer)
    {
        if (($question = $answer->getQuestion())) {
            // Build new form to show to user
            if (($questionTrue = $question->getQuestionTrue())) {
                if (!$answer->getValue()) {
                    // Check if answer is false and
                    // question for false-answer exists,
                    // than return this false-question
                    if (($questionFalse = $question->getQuestionFalse())) {
                        return $questionFalse;
                    }
                }
                return $questionTrue;
            }
        }
        return null;
    }

    /**
     * Accept responses from chat dialog
     * @param Request $request
     * @return null|Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function chatAjaxAction(Request $request)
    {
        // Display emotion questions
        // as a first question
        if (($response = $this->chatEmotionAjaxAction($request))) {
            return $response;
        }

        if ($request->isMethodSafe()) {
            // If user already answered a questions
            // show answer history
            if (($response = $this->chatHistoryAjaxAction($request))) {
                return $response;
            }
            // If user not answered
            // and do not seen this dialog
            // or see a dialog at first
            // show initial question
            if (($response = $this->chatInitialAjaxAction($request))) {
                return $response;
            }
        }

        // we do not know what kind of form there are
        // we have to get a question first, that
        // we can calculate a form type using a question
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            $formTemp = $this->createForm(new GamificationUserDialogAnswerHiddenForm(), new GamificationUserDialogAnswer());
            if ($request->get($formTemp->getName())) {
                $formTemp->handleRequest($request);
                if (($userAnswer = $formTemp->getData())) {

                    $repositoryGamificationDialogQuestion = $this->get('fitbase_entity_manager')
                        ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

                    if (($question = $repositoryGamificationDialogQuestion->find($userAnswer->getQuestionId()))) {
                        // Needs to choose form with respect to question type
                        // as example, yes-no questions and text questions
                        $form = $this->createFormGamification($question, $userAnswer);
                        if ($request->get($form->getName())) {
                            $form->handleRequest($request);
                            if ($form->isValid()) {

                                // Store user answer here using
                                // chain responsibility
                                $userAnswer->setUser($user);
                                $userAnswer->setQuestion($question);
                                $userAnswer->setQuestionId($question->getId());
                                $userAnswer->setDate($this->get('datetime')->getDateTime('now'));

                                $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($userAnswer);
                                $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_create', $gamificationDialogUserAnswerEvent);

                                if ($question->getType() == 'trash') {
                                    $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($userAnswer);
                                    $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_hide_collection', $gamificationDialogUserAnswerEvent);
                                }

                                // Display next question
                                // after current question was answered
                                if (($response = $this->chatNextAjaxAction($request, $userAnswer))) {
                                    return $response;
                                }
                            }

                            return $this->render('FitbaseGamificationBundle:Dashboard:chat_question.html.twig', array(
                                'form' => $form->createView(),
                                'question' => $question,
                            ));
                        }
                    }
                }
            }
        }

        throw new NotFoundHttpException('Only for POST requests');
    }

    /**
     * Display chat emotion
     * @param Request $request
     * @return null|Response
     */
    protected function chatEmotionAjaxAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $repositoryGamificationUserEmotion = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion');

            $datetime = $this->get('datetime')->getDateTime('now');
            if (!$repositoryGamificationUserEmotion->findOneByUserAndDate($user, $datetime)) {

                $gamificationUserEmotion = new GamificationUserEmotion();
                $gamificationUserEmotion->setUser($user);
                $gamificationUserEmotion->setDate($datetime);

                $form = $this->createForm(new GamificationUserEmotionForm(), $gamificationUserEmotion);
                if ($request->get($form->getName())) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {

                        $eventGamificationUserEmotion = new GamificationUserEmotionEvent($gamificationUserEmotion);
                        $this->get('event_dispatcher')->dispatch('gamification_user_emotion_create', $eventGamificationUserEmotion);
                        // Show initial chat procedure
                        // after emotion-dialog
                        return $this->chatInitialAjaxAction($request);
                    }
                }

                return $this->render('FitbaseGamificationBundle:Dashboard:chat_emotion.html.twig', array(
                    'form' => $form->createView(),
                ));
            }
        }

        return null;
    }


    /**
     * Display next chat question for user
     * @param Request $request
     * @param $answer
     * @return null|Response
     */
    protected function chatNextAjaxAction(Request $request, GamificationUserDialogAnswer $answer)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            if (($questionNew = $this->getQuestionNext($answer))) {
                // Needs to choose form with respect to question type
                // as example, yes/no questions and text questions
                // here only who a form
                $userAnswerNew = new GamificationUserDialogAnswer();
                $userAnswerNew->setQuestionId($questionNew->getId());
                $userAnswerNew->setValue($answer->getValue());

                $form = $this->createFormGamification($questionNew, $userAnswerNew);
                // If type is finish, store user answer
                // user become a points for finish-question
                if ($questionNew->getType() == 'finish') {

                    $userAnswerNew->setUser($user);
                    $userAnswerNew->setQuestion($questionNew);
                    $userAnswerNew->setQuestionId($questionNew->getId());
                    $userAnswerNew->setDate($this->get('datetime')->getDateTime('now'));

                    $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($userAnswerNew);
                    $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_create', $gamificationDialogUserAnswerEvent);
                    // Notify system about finished user answer
                    // for health-dialog, needs to add user points
                    $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($userAnswerNew);
                    $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_finish', $gamificationDialogUserAnswerEvent);
                }

                return $this->render('FitbaseGamificationBundle:Dashboard:chat_question.html.twig', array(
                    'form' => $form->createView(),
                    'question' => $questionNew,
                ));
            }
        }

        return null;
    }

    /**
     * Display initial chat dialog
     * @param Request $request
     * @return null|Response
     */
    protected function chatInitialAjaxAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            $repositoryGamificationDialogQuestion = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');
            // Get first question in questionnaire
            // first question marked as start=true
            if (($questionCurrent = $repositoryGamificationDialogQuestion->findOneByStart())) {

                $userAnswer = new GamificationUserDialogAnswer();
                $userAnswer->setQuestionId($questionCurrent->getId());
                $userAnswer->setQuestion($questionCurrent);

                $form = $this->createFormGamification($questionCurrent, $userAnswer);
                return $this->render('FitbaseGamificationBundle:Dashboard:chat_question.html.twig', array(
                    'form' => $form->createView(),
                    'question' => $questionCurrent,
                ));
            }
        }
        return null;
    }

    /**
     * Display chat history
     * @param Request $request
     * @return null|Response
     */
    protected function chatHistoryAjaxAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $repositoryGamificationUserDialogAnswer = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer');

            $repositoryGamificationUserEmotion = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion');

            $datetime = $this->get('datetime')->getDateTime('now');
            $emotion = $repositoryGamificationUserEmotion->findOneByUserAndDateAndNotHidden($user, $datetime);
            $collection = $repositoryGamificationUserDialogAnswer->findAllByUserAndDate($user, $datetime);

            $form = null;
            $question = null;

            if (!empty($collection) and is_array($collection) and count($collection)) {

                if (($question = $this->getQuestionNext(end($collection)))) {

                    $userAnswerNew = new GamificationUserDialogAnswer();
                    $userAnswerNew->setQuestionId($question->getId());
                    $userAnswerNew->setQuestion($question);
                    $userAnswerNew->setValue(0);

                    $form = $this->createFormGamification($question, $userAnswerNew);
                }

            } else {

                $repositoryGamificationDialogQuestion = $this->get('fitbase_entity_manager')
                    ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

                if (($question = $repositoryGamificationDialogQuestion->findOneByStart())) {

                    $userAnswerNew = new GamificationUserDialogAnswer();
                    $userAnswerNew->setQuestionId($question->getId());
                    $userAnswerNew->setQuestion($question);

                    $form = $this->createFormGamification($question, $userAnswerNew);
                }
            }

            return $this->render('FitbaseGamificationBundle:Dashboard:chat_history.html.twig', array(
                'form' => $form,
                'emotion' => $emotion,
                'question' => $question,
                'collection' => $collection,
            ));
        }

        return null;
    }

}
