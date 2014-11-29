<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class WeeklytaskController extends Controller
{
    /**
     * Display user weeklytask
     * @param Request $request
     * @param null $unique
     * @return Response
     */
    public function userViewAction(Request $request, $unique = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $weeklytask = null;

        $entityManager = $this->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

        if (($weeklytaskUser = $repositoryWeeklytask->find($unique))) {

            $event = new WeeklytaskUserEvent($weeklytaskUser);
            $this->get('event_dispatcher')->dispatch('weeklytask_user_done', $event);

            if (($weeklytask = $weeklytaskUser->getTask())) {
                // TODO:
            }

        }

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:view.html.twig', array(
            'weeklytask' => $weeklytask,
        ));
    }

    /**
     * Display user weeklyquiz
     * @param Request $request
     * @param null $unique
     * @return Response
     */
    public function userQuizViewAction(Request $request, $unique = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $weeklyquiz = null;

        $entityManager = $this->get('entity_manager');
        $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

        if (($weeklyquizUser = $repositoryWeeklyquiz->findOneByUserAndUnique($user, $unique))) {

            if ($weeklyquizUser->getDone()) {
                return $this->showUserQuizViewFormDoneAction($request, $user, $weeklyquizUser);
            }
            return $this->showUserQuizViewFormAction($request, $user, $weeklyquizUser);
        }

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:view_quiz.html.twig', array(
            'weeklyquiz' => $weeklyquiz,
        ));
    }

    /**
     * Show quiz form
     * @param Request $request
     * @param $user
     * @param $weeklyquizUser
     * @return Response
     */
    protected function showUserQuizViewFormAction(Request $request, $user, $weeklyquizUser)
    {
        $notices = array();

        $formBuilder = new WeeklyquizUserForm();
        $formBuilder->setContainer($this->container);
        $formBuilder->setWeeklyquizUser($weeklyquizUser);

        $form = $this->createForm($formBuilder, array());
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $entityManager = $this->get('entity_manager');
                $repositoryWeeklyquizAnswer = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
                $repositoryWeeklyquizQuestion = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');

                foreach ($form->getData() as $questionId => $answerId) {

                    if (($question = $repositoryWeeklyquizQuestion->find($questionId))) {
                        if (($answers = $repositoryWeeklyquizAnswer->findAllByIdArray($answerId))) {

                            $weeklytaskUserAnswer = new WeeklyquizUserAnswer();
                            $weeklytaskUserAnswer->setUser($user);
                            $weeklytaskUserAnswer->setQuestion($question);
                            $weeklytaskUserAnswer->setUserQuiz($weeklyquizUser);

                            $weeklytaskUserAnswer->setAnswerUser($answers);
                            $weeklytaskUserAnswer->setAnswerRight($question->getAnswersRight());
                            $weeklytaskUserAnswer->setCorrect($weeklytaskUserAnswer->checkCorrect());
                            $weeklytaskUserAnswer->setCountPoint(($weeklytaskUserAnswer->getCorrect() ? $question->getCountPoint() : 0));

                            $eventUserAnswer = new WeeklyquizUserAnswerEvent($weeklytaskUserAnswer);
                            $this->get('event_dispatcher')->dispatch('weeklyquiz_user_answer_done', $eventUserAnswer);
                        }

                        if ($answers instanceof WeeklyquizAnswer) {
                            $answers = array($answers);
                        }

                        foreach ($answers as $weeklytaskAnswer) {
                            array_push($notices, array(
                                'id' => $weeklytaskAnswer->getId(),
                                'text' => $weeklytaskAnswer->getDescription(),
                                'correct' => $weeklytaskAnswer->getCorrect(),
                            ));
                        }
                    }

                }

                $weeklytaskUserQuizEvent = new WeeklyquizUserEvent($weeklyquizUser);
                $this->get('event_dispatcher')->dispatch('weeklyquiz_user_done', $weeklytaskUserQuizEvent);
            }
        }

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:view_quiz.html.twig', array(
            'form' => $form->createView(),
            'notices' => $notices,
            'weeklyquiz' => $weeklyquizUser,
        ));
    }

    /**
     * Show processed quiz
     * @param Request $request
     * @param $user
     * @param $weeklyquizUser
     * @return Response
     */
    protected function showUserQuizViewFormDoneAction(Request $request, $user, $weeklyquizUser)
    {
        $notices = array();

        $formBuilder = new WeeklyquizUserForm();
        $formBuilder->setContainer($this->container);
        $formBuilder->setWeeklyquizUser($weeklyquizUser);


        $entityManager = $this->get('entity_manager');
        $repositoryWeeklyquizUserAnswer = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer');

        $result = array();
        // Get user answers for this quiz
        if (($answersUser = $repositoryWeeklyquizUserAnswer->findAllByUserAndUserQuiz($user, $weeklyquizUser))) {
            foreach ($answersUser as $answerUser) {
                // Get current question for
                // answer-set
                if (($question = $answerUser->getQuestion())) {

                    $resultAnswers = array();
                    // get the system answers with
                    // description and other, use only
                    // user-chosen answers
                    if (($answers = $answerUser->getAnswerUser())) {
                        foreach ($answers as $answer) {

                            // append answer properties
                            // to show as a help information
                            // on a form
                            array_push($notices, array(
                                'id' => $answer->getId(),
                                'text' => $answer->getDescription(),
                                'correct' => $answer->getCorrect(),
                            ));

                            // Append answer id to
                            // array with results to show on form
                            array_push($resultAnswers, $answer->getId());
                        }
                    }

                    $result[$question->getId()] = $resultAnswers;
                }
            }
        }

        $form = $this->createForm($formBuilder, $result);

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:view_quiz.html.twig', array(
            'form' => $form->createView(),
            'notices' => $notices,
            'weeklyquiz' => $weeklyquizUser->getQuiz(),
        ));
    }
}