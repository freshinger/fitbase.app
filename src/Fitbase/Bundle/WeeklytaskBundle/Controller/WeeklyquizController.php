<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizQuestionEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizAnswerForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklytaskForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizQuestionForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizSearchForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklytaskSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizUserForm;

class WeeklyquizController extends Controller
{
    public function indexAction(Request $request)
    {
        $managerEntity = $this->get('entity_manager');
        $repositoryWeeklyquiz = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
//        $repositoryWeeklyquizQuestion = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');
//        $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');


        if (($weeklyquiz = $repositoryWeeklyquiz->findOneById(13))) {
            //TODO:
        }

        $weeklytaskUserQuiz = new WeeklyquizUser();
        $weeklytaskUserQuiz->setQuizId(13);

        $formBuilder = new WeeklyquizUserForm();
        $formBuilder->setContainer($this->container);
        $formBuilder->setWeeklyquizUser($weeklytaskUserQuiz);

        $form = $this->createForm($formBuilder, array());


        return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz.html.twig', array(
            'form' => $form->createView(),
            'weeklyquiz' => $weeklyquiz,
        ));
    }



//    public function weeklyquizAction(Request $request)
//    {
//        if (($unique = $request->get('weeklyquiz_create'))) {
//            return $this->weeklyquizCreateAction($request);
//        }
//
//        if (($unique = $request->get('weeklyquiz_id_edit'))) {
//            return $this->weeklyquizUpdateAction($request, $unique);
//        }
//
//        if (($unique = $request->get('question_id_edit'))) {
//            return $this->weeklyquizQuestionUpdateAction($request, $unique);
//        }
//
//        if (($unique = $request->get('question_id_remove'))) {
//            return $this->weeklyquizQuestionRemoveAction($request, $unique);
//        }
//
//        if (($unique = $request->get('answer_id_edit'))) {
//            return $this->weeklyquizAnswerUpdateAction($request, $unique);
//        }
//
//        if (($unique = $request->get('answer_id_remove'))) {
//            return $this->weeklyquizAnswerRemoveAction($request, $unique);
//        }
//
//
//        if (($unique = $request->get('weeklyquiz_id_remove'))) {
//            $this->weeklyquizRemoveAction($request, $unique);
//        }
//
//        $weeklytaskSearch = new WeeklytaskSearch();
//        $formSearch = $this->createForm(new WeeklyquizSearchForm(), $weeklytaskSearch);
//        if ($request->get($formSearch->getName())) {
//            $formSearch->handleRequest($request);
//        }
//
//        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
//
//
//        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter(
//            $repositoryWeeklytask->findAllQueryBuilder($weeklytaskSearch)
//        ));
//
//        $pagerfanta->setMaxPerPage(50);
//        $pagerfanta->setCurrentPage($request->get('navigate', 1));
//
//
//        return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz.html.twig', array(
//            'formSearch' => $formSearch->createView(),
//            'pagerfanta' => $pagerfanta,
//            'categories' => array(),
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//    }
//
//
//    /**
//     * Display
//     * @param Request $request
//     * @param $unique
//     * @return Response|\Symfony\Component\HttpFoundation\Response
//     */
//    public function weeklyquizShowAction(Request $request)
//    {
//        if (!($unique = $request->get('weeklyquiz_id_show'))) {
//            return new Response('', 200);
//        }
//
//        $managerEntity = $this->get('fitbase_entity_manager');
//        $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
//
//        $weeklytaskUserQuiz = new WeeklyquizUser();
//        $weeklytaskUserQuiz->setQuizId($unique);
//
//        $formBuilder = new WeeklyquizUserForm();
//        $formBuilder->setContainer($this->container);
//        $formBuilder->setWeeklyquizUser($weeklytaskUserQuiz);
//
//        $form = $this->createForm($formBuilder, array());
//
//        return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:quiz.html.twig', array(
//            'form' => $form->createView(),
//            'quiz' => $repositoryWeeklytask->find($unique),
//        ));
//    }
//
//    /**
//     * Action to remove weekly task
//     * @param Request $request
//     * @param null $unique
//     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse
//     */
//    public function weeklyquizRemoveAction(Request $request, $unique)
//    {
//        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
//
//        if (($weeklytask = $repositoryWeeklytask->find($unique))) {
//
//            $event = new WeeklytaskEvent($weeklytask);
//            $this->get('event_dispatcher')->dispatch('weeklytask_quiz_remove', $event);
//
//            $this->get('session')->getFlashBag()->add('notice', 'Das Quiz wurde erfolgreich geloescht.');
//
//            return $this->redirect('?page=wochenquizzen');
//        }
//    }
//
//    /**
//     * Create weeklytask
//     * @param Request $request
//     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function weeklyquizCreateAction(Request $request)
//    {
//        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
//
//        $form = $this->createForm(new WeeklyquizForm(), new Weeklyquiz());
//        if ($request->get($form->getName())) {
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//
//                $event = new WeeklyquizEvent($form->getData());
//                $this->get('event_dispatcher')->dispatch('weeklytask_quiz_create', $event);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Das Quiz wurde erfolgreich angelegt.');
//
//                return $this->redirect('?page=wochenquizzen');
//            }
//        }
//
//        return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz_create.html.twig', array(
//            'form' => $form->createView(),
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//    }
//
//    /**
//     * @param Request $request
//     * @param null $unique
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function weeklyquizUpdateAction(Request $request, $unique = null)
//    {
//        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
//
//        if (($weeklytaskQuiz = $repositoryWeeklytask->find($unique))) {
//
//            $form = $this->createForm(new WeeklyquizForm(), $weeklytaskQuiz);
//            if ($request->get($form->getName())) {
//                $form->handleRequest($request);
//                if ($form->isValid()) {
//
//                    $event = new WeeklytaskEvent($form->getData());
//                    $this->get('event_dispatcher')->dispatch('weeklytask_quiz_update', $event);
//
//                    $this->get('session')->getFlashBag()->add('notice', 'Die Quizdaten wurden erfolgreich geaendert.');
//
//                    return $this->redirect('?page=wochenquizzen');
//                }
//            }
//
//            $weeklytaskQuestion = new WeeklyquizQuestion();
//            $weeklytaskQuestion->setQuiz($weeklytaskQuiz);
//            $weeklytaskQuestion->setType('radiobutton');
//
//            $formQuestion = $this->createForm(new WeeklyquizQuestionForm(), $weeklytaskQuestion);
//            if ($request->get($formQuestion->getName())) {
//                $formQuestion->handleRequest($request);
//                if ($formQuestion->isValid()) {
//
//                    $event = new WeeklyquizQuestionEvent($weeklytaskQuestion);
//                    $this->get('event_dispatcher')->dispatch('weeklytask_question_create', $event);
//                }
//            }
//
//            $repositoryWeeklyquizQuestion = $this->get('fitbase_entity_manager')
//                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');
//
//
//            return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz_update.html.twig', array(
//                'form' => $form->createView(),
//                'formQuestion' => $formQuestion->createView(),
//                'weeklytaskQuiz' => $weeklytaskQuiz,
//                'collection' => $repositoryWeeklyquizQuestion->findAllByQuiz($weeklytaskQuiz),
//                'flashbag' => $this->get('session')->getFlashBag(),
//            ));
//        }
//    }
//
//    /**
//     * Update question
//     * @param Request $request
//     * @param null $unique
//     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function weeklyquizQuestionUpdateAction(Request $request, $unique = null)
//    {
//        $repositoryWeeklyquizQuestion = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');
//
//        if (($weeklytaskQuestion = $repositoryWeeklyquizQuestion->find($unique))) {
//
//            $form = $this->createForm(new WeeklyquizQuestionForm(), $weeklytaskQuestion);
//            if ($request->get($form->getName())) {
//                $form->handleRequest($request);
//                if ($form->isValid()) {
//
//                    $event = new WeeklyquizQuestionEvent($weeklytaskQuestion);
//                    $this->get('event_dispatcher')->dispatch('weeklytask_question_update', $event);
//
//                    if (($weeklytaskQuizId = $weeklytaskQuestion->getQuizId())) {
//                        return $this->redirect("?page=wochenquizzen&weeklyquiz_id_edit=$weeklytaskQuizId");
//                    }
//                    return $this->redirect('?page=wochenquizzen');
//                }
//            }
//
//            $weeklytaskAnswer = new WeeklyquizAnswer();
//            $weeklytaskAnswer->setCorrect(false);
//            $weeklytaskAnswer->setQuiz($weeklytaskQuestion->getQuiz());
//            $weeklytaskAnswer->setQuestion($weeklytaskQuestion);
//
//            $formAnswer = $this->createForm(new WeeklyquizAnswerForm(), $weeklytaskAnswer);
//            if ($request->get($formAnswer->getName())) {
//                $formAnswer->handleRequest($request);
//                if ($formAnswer->isValid()) {
//
//                    $event = new WeeklyquizAnswerEvent($weeklytaskAnswer);
//                    $this->get('event_dispatcher')->dispatch('weeklytask_answer_create', $event);
//                }
//            }
//
//            $repositoryWeeklyquizAnswer = $this->get('fitbase_entity_manager')
//                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
//
//            return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz_question_update.html.twig', array(
//                'form' => $form->createView(),
//                'formAnswer' => $formAnswer->createView(),
//                'weeklytaskQuestion' => $weeklytaskQuestion,
//                'collection' => $repositoryWeeklyquizAnswer->findAllByQuestion($weeklytaskQuestion),
//                'flashbag' => $this->get('session')->getFlashBag(),
//            ));
//        }
//    }
//
//    /**
//     * Remove question
//     * @param Request $request
//     * @param null $unique
//     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse
//     */
//    public function weeklyquizQuestionRemoveAction(Request $request, $unique = null)
//    {
//        $repositoryWeeklyquizQuestion = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');
//
//        if (($weeklytaskQuestion = $repositoryWeeklyquizQuestion->find($unique))) {
//
//            $event = new WeeklyquizQuestionEvent($weeklytaskQuestion);
//            $this->get('event_dispatcher')->dispatch('weeklytask_question_remove', $event);
//
//            if (($weeklytaskQuizId = $weeklytaskQuestion->getQuizId())) {
//                return $this->redirect("?page=wochenquizzen&weeklyquiz_id_edit=$weeklytaskQuizId");
//            }
//
//            return $this->redirect('?page=wochenquizzen');
//        }
//    }
//
//    /**
//     * Update answer object
//     * @param Request $request
//     * @param $unique
//     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function weeklyquizAnswerUpdateAction(Request $request, $unique)
//    {
//        $repositoryWeeklyquizQuestion = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
//
//        if (($weeklytaskAnswer = $repositoryWeeklyquizQuestion->find($unique))) {
//
//            $form = $this->createForm(new WeeklyquizAnswerForm(), $weeklytaskAnswer);
//            if ($request->get($form->getName())) {
//                $form->handleRequest($request);
//                if ($form->isValid()) {
//
//                    $event = new WeeklyquizAnswerEvent($weeklytaskAnswer);
//                    $this->get('event_dispatcher')->dispatch('weeklytask_answer_update', $event);
//
//                    if (($weeklytaskQuestionId = $weeklytaskAnswer->getQuestionId())) {
//                        return $this->redirect("?page=wochenquizzen&question_id_edit=$weeklytaskQuestionId");
//                    }
//                    return $this->redirect('?page=wochenquizzen');
//                }
//            }
//            return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz_answer_update.html.twig', array(
//                'form' => $form->createView(),
//                'weeklytaskAnswer' => $weeklytaskAnswer,
//                'flashbag' => $this->get('session')->getFlashBag(),
//            ));
//        }
//    }
//
//    /**
//     * Remove answer object
//     * @param Request $request
//     * @param $unique
//     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse
//     */
//    public function weeklyquizAnswerRemoveAction(Request $request, $unique)
//    {
//        $repositoryWeeklyquizQuestion = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
//
//        if (($weeklytaskAnswer = $repositoryWeeklyquizQuestion->find($unique))) {
//
//            $event = new WeeklyquizAnswerEvent($weeklytaskAnswer);
//            $this->get('event_dispatcher')->dispatch('weeklytask_answer_remove', $event);
//
//            if (($weeklytaskQuestionId = $weeklytaskAnswer->getQuestionId())) {
//                return $this->redirect("?page=wochenquizzen&question_id_edit=$weeklytaskQuestionId");
//            }
//            return $this->redirect('?page=wochenquizzen');
//
//        }
//    }
//
//    /**
//     * Display list of weekly task to process and processed
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function weeklyquizPlanAction(Request $request)
//    {
//        if (($unique = $request->get('weeklyquiz_plan_send'))) {
//            $this->weeklytaskQuizPlanSendAction($request, $unique);
//        }
//
//        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizPlan');
//
//
//        $pagerfantaNotProcessed = new Pagerfanta(new DoctrineORMAdapter(
//            $repositoryWeeklytask->findAllNotProcessedQueryBuilder()
//        ));
//
//        $pagerfantaNotProcessed->setMaxPerPage(50);
//        $pagerfantaNotProcessed->setCurrentPage($request->get('notprocessed', 1));
//
//
//        $pagerfantaProcessed = new Pagerfanta(new DoctrineORMAdapter(
//            $repositoryWeeklytask->findAllProcessedQueryBuilder()
//        ));
//
//        $pagerfantaProcessed->setMaxPerPage(50);
//        $pagerfantaProcessed->setCurrentPage($request->get('processed', 1));
//
//
//        return $this->render('FitbaseWeeklytaskBundle:Weeklyquiz:weeklyquiz_plan.html.twig', array(
//            'pagerfantaProcessed' => $pagerfantaProcessed,
//            'pagerfantaNotProcessed' => $pagerfantaNotProcessed,
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//    }
//
//    /**
//     * Send weekly task
//     * @param Request $request
//     * @param $unique
//     */
//    public function weeklytaskQuizPlanSendAction(Request $request, $unique)
//    {
//        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
//            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizPlan');
//
//        if (($weeklytaskQuizPlan = $repositoryWeeklytask->find($unique))) {
//
//            $weeklytaskQuizPlanEvent = new WeeklyquizPlanEvent($weeklytaskQuizPlan);
//            $this->container->get('event_dispatcher')
//                ->dispatch('weeklytask_quiz_plan_send', $weeklytaskQuizPlanEvent);
//
//            $this->get('session')->getFlashBag()->add('notice', 'Ein Wochenquiz wurde erfolgreich versendet');
//        }
//    }
}
