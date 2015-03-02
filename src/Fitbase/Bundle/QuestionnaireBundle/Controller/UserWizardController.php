<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Controller;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserAnswerEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\Constraint\QuestionnaireQuestionConstraint;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class UserWizardController extends Controller
{
    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {
            $objectManager = $this->get('fitbase.orm.questionnaire_user_manager');
            if (($questionnaireUser = $objectManager->findOneFirstByUser($user))) {
                if (($questionnaire = $questionnaireUser->getQuestionnaire())) {

                    if (($request->get('pause'))) {

                        $questionnaireUser->setPause(true);
                        $event = new QuestionnaireUserEvent($questionnaireUser);
                        $this->get('event_dispatcher')->dispatch('questionnaire_user_update', $event);

                        return $this->questionnaireNextAction($request);
                    }


                    $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser, 10);
                    $form = $this->createForm($formBuilder, array());

                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);

                        // Validate each child
                        // form has no defined structure
                        foreach ($form as $child) {
                            if (($errors = $this->validateChild($child))) {
                                foreach ($errors as $error) {
                                    $child->addError(new FormError($error->getMessage()));
                                }
                            }
                        }

                        if ($form->isValid()) {

                            if (($points = $this->processAnswers($questionnaireUser, $form->getData())) !== null) {

                                $entityManager = $this->get('entity_manager');
                                $questionnaireUser->setCountPoint($points);
                                $entityManager->persist($questionnaireUser);
                                $entityManager->flush($questionnaireUser);

                                if (($session = $request->getSession())) {
                                    $session->getFlashBag()->add('success', 'Ihre Antworten wurden geschpeichert.');
                                }


                                $repositoryQuestionnaireQuestion = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
                                if (($count = $repositoryQuestionnaireQuestion->findCountByQuestionnaireUser($questionnaireUser))) {

                                    $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser);
                                    $form = $this->container->get('form.factory')->create($formBuilder, array());

                                    return $this->render('FitbaseQuestionnaireBundle:Wizard:questionnaire.html.twig', array(
                                        'form' => $form->createView(),
                                        'questionnaire' => $questionnaire,
                                    ));
                                }

                                $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
                                $this->get('event_dispatcher')->dispatch('questionnaire_user_done', $eventQuestionnaireUser);

                                // Try to process a new questionnaire if exists
                                // if no, method return null
                                return $this->questionnaireNextAction($request);
                            }
                        }
                    }


                    return $this->render('FitbaseQuestionnaireBundle:Wizard:questionnaire.html.twig', array(
                        'form' => $form->createView(),
                        'questionnaire' => $questionnaire,
                    ));
                }
            }
        }

        return;
    }

    /**
     * Validate questionnaire question
     * @param $form
     * @return mixed
     */
    protected function validateChild($form)
    {
        return $this->get('validator')->validateValue($form->getData(),
            new QuestionnaireQuestionConstraint());
    }

    /**
     * Process answers
     *
     * @param $questionnaireUser
     * @param $answers
     * @return int
     */
    protected function processAnswers($questionnaireUser, $answers)
    {
        // Set default point count
        // for heals and strain parameters
        $total = 0;

        foreach ($answers as $questionId => $answerId) {

            $entityManager = $this->get('entity_manager');
            $repositoryQuestionnaireQuestion = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
            if (($questionnaireQuestion = $repositoryQuestionnaireQuestion->find($questionId))) {

                $questionnaireUserAnswer = new QuestionnaireUserAnswer();
                $questionnaireUserAnswer->setUser($questionnaireUser->getUser());
                $questionnaireUserAnswer->setQuestion($questionnaireQuestion);
                $questionnaireUserAnswer->setQuestionnaireUser($questionnaireUser);

                if ((list($points, $answers, $text) = $this->calculatePoints($answerId))) {
                    // Increase total point count
                    // for health and strain for User Questionnaire object
                    $total += $points;

                    $questionnaireUserAnswer->setText($text);
                    $questionnaireUserAnswer->setAnswers($answers);
                    $questionnaireUserAnswer->setCountPoint($points);
                }

            }

            $eventQuestionnaireUserAnswer = new QuestionnaireUserAnswerEvent($questionnaireUserAnswer);
            $this->get('event_dispatcher')->dispatch('questionnaire_user_answer_create', $eventQuestionnaireUserAnswer);
        }

        return $total;
    }

    /**
     * Process questionnaire answers
     * @param $array
     * @return array|null
     */
    protected function calculatePoints($array)
    {
        $points = 0;

        if (is_numeric($array) or is_array($array)) {

            if (!is_array($array)) {
                $array = array($array);
            }

            $managerEntity = $this->get('entity_manager');
            $repositoryQuestionnaireAnswer = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');

            if (count(($answers = $repositoryQuestionnaireAnswer->findAllById($array)))) {
                foreach ($answers as $answer) {
                    $points += $answer->getCountPoint();
                }
                return array($points, $answers, null);
            }
        }

        return array(0, array(), array_shift($array));
    }


    /**
     * Display form with next questionnaire if exists
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireNextAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {
            $objectManager = $this->get('fitbase.orm.questionnaire_user_manager');
            if (($questionnaireUser = $objectManager->findOneFirstByUser($user))) {
                if (($questionnaire = $questionnaireUser->getQuestionnaire())) {

                    $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser, 10);
                    $form = $this->container->get('form.factory')->create($formBuilder, array());
                    return $this->render('FitbaseQuestionnaireBundle:Wizard:questionnaire.html.twig', array(
                        'form' => $form->createView(),
                        'questionnaire' => $questionnaire,
                    ));
                }
            }
        }
        return;
    }
}
