<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Listener;


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
            KernelEvents::RESPONSE => array('onKernelResponse', -128),
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
     * Get current content
     * @param Request $request
     * @return Response
     */
    protected function getContentQuestionnaire(Request $request)
    {
        $user = $this->container->get('user')->current();

        $managerEntity = $this->container->get('entity_manager');
        $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
        $repositoryQuestionnaireAnswer = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');
        $repositoryQuestionnaireQuestion = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');

        if (($questionnaireUser = $repositoryQuestionnaireUser->findOneByUserAndNotDoneAndNotPause($user))) {

            if (($request->get('pause'))) {
                $questionnaireUser->setPause(true);
                $event = new QuestionnaireUserEvent($questionnaireUser);
                $this->container->get('event_dispatcher')->dispatch('questionnaire_user_update', $event);


                $url = null;

                return new RedirectResponse($this->container->get('router')->generate($request->get('_route'), array(
                    'path' => $request->get('path')
                )));
            }


            if (($questionnaire = $questionnaireUser->getQuestionnaire())) {

                $formBuilder = new QuestionnaireUserForm();
                $formBuilder->setContainer($this->container);
                $formBuilder->setQuestionnaireUser($questionnaireUser);

                $form = $this->container->get('form.factory')->create($formBuilder, array());
                if ($request->get($form->getName())) {
                    $form->handleRequest($request);

                    $validator = $this->container->get('validator');
                    foreach ($form as $child) {
                        $errors = $validator->validateValue($child->getData(), new QuestionnaireQuestionConstraint());
                        foreach ($errors as $error) {
                            $child->addError(new FormError($error->getMessage()));
                        }
                    }


                    if ($form->isValid()) {

                        // Set default point count
                        // for heals and strain parameters
                        $pointHealthTotal = 0;
                        $pointStrainTotal = 0;

                        foreach ($form->getData() as $questionId => $answerId) {

                            $pointHealth = 0;
                            $pointStrain = 0;

                            if (!($questionnaireQuestion = $repositoryQuestionnaireQuestion->find($questionId))) {
                                $this->container->get('logger')->debug('[fitbase] Questionnaire done, question not found', array($questionId));
                                continue;
                            }

                            $questionnaireUserAnswer = new QuestionnaireUserAnswer();
                            $questionnaireUserAnswer->setUser($questionnaireUser->getUser());
                            $questionnaireUserAnswer->setQuestion($questionnaireQuestion);
                            $questionnaireUserAnswer->setQuestionnaireUser($questionnaireUser);
                            // check is answer selected
                            // and answer is a object(radio, slider)
                            // or array of objects (checkbox)
                            if (is_numeric($answerId) or is_array($answerId)) {

                                if (!is_array($answerId)) {
                                    $answerId = array($answerId);
                                }

                                if (($questionnaireAnswer = $repositoryQuestionnaireAnswer->findAllById($answerId))) {

                                    if (is_array($questionnaireAnswer)) {
                                        foreach ($questionnaireAnswer as $answer) {
                                            $pointHealth += $answer->getCountPointHealth();
                                            $pointStrain += $answer->getCountPointStrain();
                                        }
                                    }

                                    $questionnaireUserAnswer->setAnswers($questionnaireAnswer);
                                    $questionnaireUserAnswer->setCountPointHealth($pointHealth);
                                    $questionnaireUserAnswer->setCountPointStrain($pointStrain);
                                }
                                // Check is answer is a text
                                // that means a text field
                            } else {
                                $questionnaireUserAnswer->setText($answerId);
                                $questionnaireUserAnswer->setCountPointHealth(0);
                                $questionnaireUserAnswer->setCountPointStrain(0);
                            }
                            // Increase total point count
                            // for health and strain for User Questionnaire object
                            $pointHealthTotal += $pointHealth;
                            $pointStrainTotal += $pointStrain;

                            $eventQuestionnaireUserAnswer = new QuestionnaireUserAnswerEvent($questionnaireUserAnswer);
                            $this->container->get('event_dispatcher')->dispatch('questionnaire_user_answer_create', $eventQuestionnaireUserAnswer);
                        }

                        $questionnaireUser->setCountPointHealth($pointHealthTotal);
                        $questionnaireUser->setCountPointStrain($pointStrainTotal);

                        $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
                        $this->container->get('event_dispatcher')->dispatch('questionnaire_user_done', $eventQuestionnaireUser);

                        return $this->container->get('templating')->renderResponse('FitbaseQuestionnaireBundle:Block:questionnaire_done.html.twig', array(
                            'questionnaire' => $questionnaire,
                            'questionnaireUser' => $questionnaireUser,
                        ));
                    }
                }

                return $this->container->get('templating')
                    ->render('FitbaseQuestionnaireBundle:Block:questionnaire.html.twig', array(
                        'form' => $form->createView(),
                        'questionnaire' => $questionnaire,
                    ));

            }
        }

        return null;
    }
}