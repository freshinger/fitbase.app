<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Listener;


use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserAnswerEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\Constraint\QuestionnaireQuestionConstraint;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class QuestionnaireControllerSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', 128),
        );
    }

    /**
     * Process kernel response
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        if (!$event->isMasterRequest()) {
            return;
        }

        // do not capture redirects or modify XML HTTP Requests
        if ($request->isXmlHttpRequest()) {
            return;
        }

        $request = $this->container->get('request');
        if (($content = $this->getContentQuestionnaire($request))) {
            if ($content instanceof Response) {
                $event->setResponse($content);
            } else {
                $response->setContent($content);
                $response->setStatusCode(200);
            }
        }
    }


    /**
     * Mark QuestionnaireUser object as paused
     * @param QuestionnaireUser $questionnaireUser
     * @return bool
     */
    protected function doQuestionnairePause(QuestionnaireUser $questionnaireUser)
    {
        $questionnaireUser->setPause(true);
        $event = new QuestionnaireUserEvent($questionnaireUser);
        $this->container->get('event_dispatcher')->dispatch('questionnaire_user_update', $event);

        return true;
    }

    /**
     * Validate form without object, with array values only
     * @param $form
     * @return mixed
     */
    protected function doQuestionnaireAnswerValidate($form)
    {
        $validator = $this->container->get('validator');
        return $validator->validateValue($form->getData(), new QuestionnaireQuestionConstraint());
    }

    /**
     * Process questionnaire answers
     * @param $array
     * @return array|null
     */
    protected function doQuestionnaireAnswersCalculate($array)
    {
        $points = 0;

        if (is_numeric($array) or is_array($array)) {

            if (!is_array($array)) {
                $array = array($array);
            }

            $managerEntity = $this->container->get('entity_manager');
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
     * Get current content
     * @param Request $request
     * @return Response
     */
    protected function getContentQuestionnaire(Request $request)
    {

        $managerEntity = $this->container->get('entity_manager');
        if (($user = $this->container->get('user')->current())) {

            $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
            if (($questionnaireUser = $repositoryQuestionnaireUser->findOneByUserAndNotDoneAndNotPause($user))) {

                if (($request->get('pause'))) {
                    if ($this->doQuestionnairePause($questionnaireUser)) {
                        return new RedirectResponse($this->container->get('router')->generate($request->get('_route'), array(
                            'path' => $request->get('path')
                        )));
                    }
                }

                if (($questionnaire = $questionnaireUser->getQuestionnaire())) {

                    $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser);
                    $form = $this->container->get('form.factory')->create($formBuilder, array());
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);

                        foreach ($form as $child) {
                            if (($errors = $this->doQuestionnaireAnswerValidate($child))) {
                                foreach ($errors as $error) {
                                    $child->addError(new FormError($error->getMessage()));
                                }
                            }
                        }

                        if ($form->isValid()) {
                            // Set default point count
                            // for heals and strain parameters
                            $pointTotal = 0;

                            foreach ($form->getData() as $questionId => $answerId) {

                                $repositoryQuestionnaireQuestion = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
                                if (!($questionnaireQuestion = $repositoryQuestionnaireQuestion->find($questionId))) {
                                    continue;
                                }

                                $questionnaireUserAnswer = new QuestionnaireUserAnswer();
                                $questionnaireUserAnswer->setUser($questionnaireUser->getUser());
                                $questionnaireUserAnswer->setQuestion($questionnaireQuestion);
                                $questionnaireUserAnswer->setQuestionnaireUser($questionnaireUser);

                                if ((list($points, $answers, $text) = $this->doQuestionnaireAnswersCalculate($answerId))) {
                                    // Increase total point count
                                    // for health and strain for User Questionnaire object
                                    $pointTotal += $points;

                                    $questionnaireUserAnswer->setText($text);
                                    $questionnaireUserAnswer->setAnswers($answers);
                                    $questionnaireUserAnswer->setCountPoint($points);
                                }

                                $eventQuestionnaireUserAnswer = new QuestionnaireUserAnswerEvent($questionnaireUserAnswer);
                                $this->container->get('event_dispatcher')->dispatch('questionnaire_user_answer_create', $eventQuestionnaireUserAnswer);
                            }

                            $questionnaireUser->setCountPoint($pointTotal);

                            $repositoryQuestionnaireQuestion = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
                            if (!$repositoryQuestionnaireQuestion->findCountByQuestionnaireUser($questionnaireUser)) {

                                $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
                                $this->container->get('event_dispatcher')->dispatch('questionnaire_user_done', $eventQuestionnaireUser);

                                $this->container->get('request')->getSession()->set('questionnaire_step', '1');
                            }

                        } else {
                            return $this->container->get('templating')->render('FitbaseQuestionnaireBundle:Block:questionnaire.html.twig', array(
                                'form' => $form->createView(),
                                'questionnaire' => $questionnaire,
                            ));
                        }

                    } else {
                        return $this->container->get('templating')->render('FitbaseQuestionnaireBundle:Block:questionnaire.html.twig', array(
                            'form' => $form->createView(),
                            'questionnaire' => $questionnaire,
                        ));
                    }
                }
            }

            if (($session = $this->container->get('request')->getSession())) {
                if (($questionnaireStep = $session->get('questionnaire_step'))) {

                    $response = new Response();

                    $event = new FilterResponseEvent(
                        $this->container->get('kernel'),
                        $this->container->get('request'),
                        HttpKernelInterface::SUB_REQUEST,
                        $response);

                    $this->container->get('event_dispatcher')
                        ->dispatch("questionnaire_step_{$questionnaireStep}", $event);

                    if (($response = $event->getResponse())) {
                        if (strlen($response->getContent())) {
                            return $response;
                        }
                        $session->remove('questionnaire_step');
                    }
                }
            }

            $this->container->get('entity_manager')->refresh($user);
        }

        return null;
    }
}