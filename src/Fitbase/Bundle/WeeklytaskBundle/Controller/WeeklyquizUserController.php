<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;

use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer;

use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizUserForm;

use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeeklyquizUserController extends Controller
{
    /**
     * Process user request to save quiz
     * @param Request $request
     * @return Response
     */
    public function weeklyquizUserAjaxAction(Request $request)
    {
        if (($quizCode = $request->get('quizcode'))) {
            if (($user = $this->get('user')->current())) {

                $managerEntity = $this->get('entity_manager');
                $repositoryWeeklyquizAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
                $repositoryWeeklyquizQuestion = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');
                $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

                if (($weeklytaskUserQuiz = $repositoryWeeklyquizUser->findOneByUserAndCode($user, $quizCode))) {

                    if ($weeklytaskUserQuiz->getDone()) {
                        return new Response(json_encode('Sie haben schon geantwortet'), 500);
                    }

                    $formBuilder = new WeeklyquizUserForm();
                    $formBuilder->setContainer($this->container);
                    $formBuilder->setWeeklyquizUser($weeklytaskUserQuiz);

                    $form = $this->createForm($formBuilder, array());
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);
                        if ($form->isValid()) {

                            $notices = array();
                            foreach ($form->getData() as $questionId => $answerId) {

                                $answers = $repositoryWeeklyquizAnswer->find($answerId);
                                $question = $repositoryWeeklyquizQuestion->find($questionId);

                                $weeklytaskUserAnswer = new WeeklyquizUserAnswer();
                                $weeklytaskUserAnswer->setUser($user);
                                $weeklytaskUserAnswer->setQuestion($question);
                                $weeklytaskUserAnswer->setAnswerUser($answers);
                                $weeklytaskUserAnswer->setQuiz($question->getQuiz());
                                $weeklytaskUserAnswer->setAnswerRight($question->getAnswersRight());
                                $weeklytaskUserAnswer->setCorrect($weeklytaskUserAnswer->checkCorrect());
                                $weeklytaskUserAnswer->setCountPoint(($weeklytaskUserAnswer->getCorrect() ? $question->getCountPoint() : 0));

                                $eventUserAnswer = new WeeklyquizUserAnswerEvent($weeklytaskUserAnswer);
                                $this->get('event_dispatcher')->dispatch('weeklyquiz_user_answer_done', $eventUserAnswer);


                                if ($answers instanceof WeeklyquizAnswer) {
                                    $notices[$answers->getId()] = array(
                                        'text' => $answers->getDescription(),
                                        'correct' => $answers->getCorrect(),
                                    );
                                } else {
                                    foreach ($answers as $weeklytaskAnswer) {
                                        $notices[$weeklytaskAnswer->getId()] = array(
                                            'text' => $weeklytaskAnswer->getDescription(),
                                            'correct' => $weeklytaskAnswer->getCorrect(),
                                        );
                                    }
                                }

                                $weeklytaskAnswerEvent = new WeeklyquizAnswerEvent($weeklytaskAnswer);
                                $this->get('event_dispatcher')->dispatch('weeklytask_user_answer_created', $weeklytaskAnswerEvent);
                            }

                            $weeklytaskUserQuizEvent = new WeeklyquizUserEvent($weeklytaskUserQuiz);
                            $this->get('event_dispatcher')->dispatch('weeklyquiz_user_done', $weeklytaskUserQuizEvent);

                            return new Response(json_encode($notices), 200);
                        }
                    }
                }

            }
        }

        return new Response('Die seite nicht existiert', 404);
    }


    /**
     * Display quiz to customer
     * @param Request $request
     * @return Response
     */
    public function weeklyquizUserAction(Request $request)
    {
        if (($quizCode = $request->get('quizcode'))) {
            if (($user = $this->get('user')->current())) {

                $managerEntity = $this->get('entity_manager');

                $repositoryWeeklyquiz = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
                $repositoryWeeklyquizAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
                $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

                if (($weeklytaskUserQuiz = $repositoryWeeklyquizUser->findOneByUserAndCode($user, $quizCode))) {

                    if ($weeklytaskUserQuiz->getDone()) {

                        return $this->render('FitbaseWeeklytaskBundle:WeeklyquizUser:done.html.twig', array(
                            'quiz' => $repositoryWeeklyquiz->find($weeklytaskUserQuiz->getQuizId()),
                        ));
                    }

                    $formBuilder = new WeeklyquizUserForm();
                    $formBuilder->setContainer($this->container);
                    $formBuilder->setWeeklyquizUser($weeklytaskUserQuiz);

                    $form = $this->createForm($formBuilder, array());

                    return $this->render('FitbaseWeeklytaskBundle:WeeklyquizUser:quiz.html.twig', array(
                        'form' => $form->createView(),
                        'quiz' => $repositoryWeeklyquiz->find($weeklytaskUserQuiz->getQuizId()),
                        'userQuiz' => $weeklytaskUserQuiz,
                    ));
                }
            }
        }

        return new Response('', 200);
    }
}
