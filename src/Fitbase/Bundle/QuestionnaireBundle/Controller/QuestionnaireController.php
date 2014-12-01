<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Controller;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireController extends Controller
{
    public function indexAction(Request $request)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');


        $questionnaire = null;
        if (($questionnaire = $repositoryQuestionnaire->findOneById(1))) {


            // TODO:
        }

        $questionnaireUser = new QuestionnaireUser();
        $questionnaireUser->setQuestionnaire($questionnaire);

        $formBuilder = new QuestionnaireUserForm();
        $formBuilder->setContainer($this->container);
        $formBuilder->setQuestionnaireUser($questionnaireUser);
        $form = $this->createForm($formBuilder, array());


        return $this->render("FitbaseQuestionnaireBundle:Questionnaire:index.html.twig", array(
            'form' => $form->createView(),
            'questionnaire' => $questionnaire,
        ));
    }



//    public function statisticAction(Request $request)
//    {
//        $repositoryQuestionnaireUser = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
//
//        $questionnaireSearch = new QuestionnaireSearch();
//        $questionnaireSearch->setOrder('id');
//        $questionnaireSearch->setBy('desc');
//
//        $formSearch = $this->createForm(new QuestionnaireSearchForm(), $questionnaireSearch);
//        if ($request->get($formSearch->getName())) {
//            $formSearch->handleRequest($request);
//        }
//
//        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter(
//            $repositoryQuestionnaireUser->findAllQueryBuilder($questionnaireSearch)
//        ));
//
//        $pagerfanta->setMaxPerPage(50);
//        $pagerfanta->setCurrentPage($request->get('navigate', 1));
//
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:statistic.html.twig', array(
//            'formSearch' => $formSearch->createView(),
//            'pagerfanta' => $pagerfanta,
//            'flashbag' => $this->get('session')->getFlashBag(),
//            'user' => $this->get('user')->current(),
//        ));
//    }

//    /**
//     * Display list of questionnaire
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function listAction(Request $request)
//    {
//        // show form to create
//        // new questionnaire
//        if ($request->get('questionnaire_create')) {
//            return $this->questionnaireCreateAction($request);
//        }
//        // show form to update new
//        // show list of questions,
//        // update remove and create new questions
//        if (($unique = $request->get('questionnaire_id_edit'))) {
//            return $this->questionnaireUpdateAction($request, $unique);
//        }
//        if (($unique = $request->get('questionnaire_id_remove'))) {
//            return $this->questionnaireRemoveAction($request, $unique);
//        }
//        // show form to update question
//        //show list with answers
//        // update remove and create new answers
//        if (($unique = $request->get('question_id_edit'))) {
//            return $this->questionnaireQuestionUpdateAction($request, $unique);
//        }
//        if (($unique = $request->get('question_id_remove'))) {
//            return $this->questionnaireQuestionRemoveAction($request, $unique);
//        }
//
//        if (($unique = $request->get('answer_id_edit'))) {
//            return $this->questionnaireAnswerUpdateAction($request, $unique);
//        }
//        if (($unique = $request->get('answer_id_remove'))) {
//            return $this->questionnaireAnswerRemoveAction($request, $unique);
//        }
//
//
//        $repositoryQuestionnaire = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');
//
//        $questionnaireSearch = new QuestionnaireSearch();
//        $questionnaireSearch->setOrder('id');
//        $questionnaireSearch->setBy('asc');
//
//        $formSearch = $this->createForm(new QuestionnaireSearchForm(), $questionnaireSearch);
//        if ($request->get($formSearch->getName())) {
//            $formSearch->handleRequest($request);
//        }
//
//        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter(
//            $repositoryQuestionnaire->findAllQueryBuilder($questionnaireSearch)
//        ));
//
//        $pagerfanta->setMaxPerPage(50);
//        $pagerfanta->setCurrentPage($request->get('navigate', 1));
//
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:list.html.twig', array(
//            'formSearch' => $formSearch->createView(),
//            'pagerfanta' => $pagerfanta,
//            'flashbag' => $this->get('session')->getFlashBag(),
//            'user' => $this->get('user')->current(),
//        ));
//    }
//
//
//    /**
//     * @param Request $request
//     * @return Response|\Symfony\Component\HttpFoundation\Response
//     */
//    public function showAction(Request $request)
//    {
//        if (!($unique = $request->get('questionnaire_id_show'))) {
//            return new Response('', 200);
//        }
//
//        $managerEntity = $this->get('entity_manager');
//        $repositoryQuestionnaire = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');
//
//        $questionnaireUser = new QuestionnaireUser();
//        $questionnaireUser->setQuestionnaire($repositoryQuestionnaire->find($unique));
//
//
//        $formBuilder = new QuestionnaireUserForm();
//        $formBuilder->setContainer($this->container);
//        $formBuilder->setQuestionnaireUser($questionnaireUser);
//
//        $form = $this->createForm($formBuilder, array());
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:show.html.twig', array(
//            'form' => $form->createView(),
//            'questionnaire' => $questionnaireUser->getQuestionnaire(),
//        ));
//
//        return new Response('', 200);
//    }
//
//
//    /**
//     * Remove answer
//     * @param $request
//     * @param $unique
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function questionnaireAnswerRemoveAction($request, $unique)
//    {
//        $repositoryQuestionnaireAnswer = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');
//
//        $answer = $repositoryQuestionnaireAnswer->find($unique);
//
//        $eventQuestionnaireAnswer = new QuestionnaireAnswerEvent($answer);
//        $this->get('event_dispatcher')->dispatch('questionnaire_answer_remove', $eventQuestionnaireAnswer);
//
//        $this->get('session')->getFlashBag()->add('notice', 'Eine neue Antwort wurde erfolgreich gelöscht.');
//
//        return $this->redirect('?page=questionnaire&question_id_edit=' . $answer->getQuestion()->getId());
//
//    }
//
//    /**
//     * Display answer edit form
//     * @param $request
//     * @param $unique
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function questionnaireAnswerUpdateAction($request, $unique)
//    {
//        $repositoryQuestionnaireAnswer = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');
//
//        $answer = $repositoryQuestionnaireAnswer->find($unique);
//
//        $form = $this->createForm(new QuestionnaireAnswerForm(), $answer);
//        if ($request->get($form->getName())) {
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//
//                $eventQuestionnaireAnswer = new QuestionnaireAnswerEvent($form->getData());
//                $this->get('event_dispatcher')->dispatch('questionnaire_answer_update', $eventQuestionnaireAnswer);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Eine neue Antwort wurde erfolgreich angelegt.');
//
//                return $this->redirect('?page=questionnaire&question_id_edit=' . $answer->getQuestion()->getId());
//            }
//        }
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:answer.html.twig', array(
//            'form' => $form->createView(),
//            'answer' => $answer,
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//    }
//
//    /**
//     * remove question
//     * @param $request
//     * @param $unique
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function questionnaireQuestionRemoveAction($request, $unique)
//    {
//        $repositoryQuestionnaireQuestion = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
//
//        $question = $repositoryQuestionnaireQuestion->find($unique);
//
//        $eventQuestionnaireQuestion = new QuestionnaireEvent($question);
//        $this->get('event_dispatcher')->dispatch('questionnaire_question_remove', $eventQuestionnaireQuestion);
//
//        $this->get('session')->getFlashBag()->add('notice', 'Die Frage wurde erfolgreich geschpeichert.');
//
//        return $this->redirect('?page=questionnaire&questionnaire_id_edit=' . $question->getQuestionnaire()->getId());
//    }
//
//    /**
//     * @param $request
//     * @param $unique
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function questionnaireQuestionUpdateAction($request, $unique)
//    {
//        $repositoryQuestionnaireQuestion = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
//
//        $question = $repositoryQuestionnaireQuestion->find($unique);
//
//        $form = $this->createForm(new QuestionnaireQuestionForm(), $question);
//        if ($request->get($form->getName())) {
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//
//                $eventQuestionnaireQuestion = new QuestionnaireEvent($form->getData());
//                $this->get('event_dispatcher')->dispatch('questionnaire_question_update', $eventQuestionnaireQuestion);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Die Frage wurde erfolgreich geschpeichert.');
//
//                return $this->redirect('?page=questionnaire&questionnaire_id_edit=' . $question->getQuestionnaire()->getId());
//            }
//        }
//
//        $answer = new QuestionnaireAnswer();
//        $answer->setQuestion($question);
//
//        $formAnswer = $this->createForm(new QuestionnaireAnswerForm(), $answer);
//        if ($request->get($formAnswer->getName())) {
//            $formAnswer->handleRequest($request);
//            if ($formAnswer->isValid()) {
//
//                $eventQuestionnaireAnswer = new QuestionnaireAnswerEvent($answer);
//                $this->get('event_dispatcher')->dispatch('questionnaire_answer_create', $eventQuestionnaireAnswer);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Eine neue Antwort wurde erfolgreich angelegt.');
//            }
//        }
//
//        $repositoryQuestionnaireAnswer = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');
//
//        switch ($question->getType()) {
//            case 'text':
//                return $this->render('FitbaseQuestionnaireBundle:Questionnaire:question_text.html.twig', array(
//                    'form' => $form->createView(),
//                    'question' => $question,
//                    'flashbag' => $this->get('session')->getFlashBag(),
//                ));
//        }
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:question.html.twig', array(
//            'form' => $form->createView(),
//            'formAnswer' => $formAnswer->createView(),
//            'question' => $question,
//            'collection' => $repositoryQuestionnaireAnswer->findAllByQuestion($question),
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//    }
//
//    /**
//     * remove questionnaire
//     * @param $request
//     * @param $unique
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function questionnaireRemoveAction($request, $unique)
//    {
//        $repositoryQuestionnaire = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');
//
//        $questionnaire = $repositoryQuestionnaire->find($unique);
//
//        $eventQuestionnaire = new QuestionnaireEvent($questionnaire);
//        $this->get('event_dispatcher')->dispatch('questionnaire_remove', $eventQuestionnaire);
//
//        $this->get('session')->getFlashBag()->add('notice', 'Ein Nenes Fragebogen wurde erfolgreich angelegt.');
//
//        return $this->redirect('?page=questionnaire');
//
//    }
//
//    /**
//     * Show page to update questionnaire
//     * @param Request $request
//     * @param $unique
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function questionnaireUpdateAction(Request $request, $unique)
//    {
//        $repositoryQuestionnaire = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');
//
//        $questionnaire = $repositoryQuestionnaire->find($unique);
//
//        $form = $this->createForm(new QuestionnaireForm(), $questionnaire);
//        if ($request->get($form->getName())) {
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//
//                $eventQuestionnaire = new QuestionnaireEvent($form->getData());
//                $this->get('event_dispatcher')->dispatch('questionnaire_update', $eventQuestionnaire);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Ein Nenes Fragebogen wurde erfolgreich angelegt.');
//
//                return $this->redirect('?page=questionnaire');
//            }
//        }
//
//        $questionnaireQuestion = new QuestionnaireQuestion();
//        $questionnaireQuestion->setQuestionnaire($questionnaire);
//
//        $formQuestion = $this->createForm(new QuestionnaireQuestionForm(), $questionnaireQuestion);
//        if ($request->get($formQuestion->getName())) {
//            $formQuestion->handleRequest($request);
//            if ($formQuestion->isValid()) {
//
//                $eventQuestionnaireQuestion = new QuestionnaireQuestionEvent($questionnaireQuestion);
//                $this->get('event_dispatcher')->dispatch('questionnaire_question_create', $eventQuestionnaireQuestion);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Eine neue Frage wurde erfolgreich angelegt.');
//            }
//        }
//
//        $repositoryQuestionnaireQuestion = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
//
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:update.html.twig', array(
//            'form' => $form->createView(),
//            'collection' => $repositoryQuestionnaireQuestion->findAllByQuestionnaire($questionnaire),
//            'formQuestion' => $formQuestion->createView(),
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//    }
//
//
//    /**
//     * Create new questionnaire
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function questionnaireCreateAction(Request $request)
//    {
//        $form = $this->createForm(new QuestionnaireForm(), new Questionnaire());
//        if ($request->get($form->getName())) {
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//
//                $eventQuestionnaire = new QuestionnaireEvent($form->getData());
//                $this->get('event_dispatcher')->dispatch('questionnaire_create', $eventQuestionnaire);
//
//                $this->get('session')->getFlashBag()->add('notice', 'Die Fragebogen wurden erfolgreich angelegt.');
//
//                return $this->redirect('?page=questionnaire');
//            }
//        }
//
//
//        return $this->render('FitbaseQuestionnaireBundle:Questionnaire:update.html.twig', array(
//            'form' => $form->createView(),
//            'flashbag' => $this->get('session')->getFlashBag(),
//        ));
//
//    }
}
