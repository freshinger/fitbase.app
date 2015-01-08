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

        if (($content = $this->getContentQuestionnaire($event->getRequest()))) {
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


    protected function doDisplayQuestionnaire($request, $user)
    {
        $managerEntity = $this->container->get('entity_manager');
        $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
        if (($questionnaireUser = $repositoryQuestionnaireUser->findOneByUserAndNotDoneAndNotPause($user))) {

            if (($request->get('pause'))) {
                if ($this->doQuestionnairePause($questionnaireUser)) {
                    return new RedirectResponse(
                        $this->container->get('router')->generate('page_slug', array(
                            'path' => '/'
                        ))
                    );
                }
            }

            if (!($questionnaire = $questionnaireUser->getQuestionnaire())) {
                return null;
            }

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
                    $managerEntity->persist($questionnaireUser);
                    $managerEntity->flush($questionnaireUser);


                    $request->getSession()->getFlashBag()->add('success',
                        'Ihre Antworten wurden geschpeichert.'
                    );

                    $repositoryQuestionnaireQuestion = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
                    if ($repositoryQuestionnaireQuestion->findCountByQuestionnaireUser($questionnaireUser)) {

                        $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser);
                        $form = $this->container->get('form.factory')->create($formBuilder, array());
                        return $this->container->get('templating')->renderResponse('FitbaseQuestionnaireBundle:Block:questionnaire.html.twig', array(
                            'form' => $form->createView(),
                            'questionnaire' => $questionnaire,
                        ));
                    }

                    $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
                    $this->container->get('event_dispatcher')->dispatch('questionnaire_user_done', $eventQuestionnaireUser);

                    if (($session = $request->getSession())) {
                        $session->set('questionnaire_step', 1);
                    }

                    return null;
                }
            }

            return $this->container->get('templating')->renderResponse('FitbaseQuestionnaireBundle:Block:questionnaire.html.twig', array(
                'form' => $form->createView(),
                'questionnaire' => $questionnaire,
            ));
        }
        return null;
    }

    protected function doDisplayQuestionnaireStep($request, $step)
    {
        $response = new Response();

        $event = new FilterResponseEvent(
            $this->container->get('kernel'),
            $request,
            HttpKernelInterface::SUB_REQUEST,
            $response);

        $this->container->get('event_dispatcher')
            ->dispatch("questionnaire_step_{$step}", $event);

        if (($response = $event->getResponse())) {
            if (strlen($response->getContent())) {
                return $response;
            }
        }
        return null;
    }

    /**
     * Get current content
     * @param Request $request
     * @return Response
     */
    protected function getContentQuestionnaire(Request $request)
    {
        if (($user = $this->container->get('user')->current())) {
            if (($response = $this->doDisplayQuestionnaire($request, $user))) {
                return $response;
            } else {

                if (($session = $request->getSession())) {
                    if (($step = $session->get('questionnaire_step'))) {

                        if (($response = $this->doDisplayQuestionnaireStep($request, $step))) {
                            $session->get('questionnaire_step', $step);
                            return $response;
                        }

                        if (!$request->isMethodSafe()) {
                            $step++;

                            $session->set('questionnaire_step', $step);
                            if (($response = $this->doDisplayQuestionnaireStep($request, $step))) {
                                return $response;
                            }

                            $session->remove('questionnaire_step');

                            return new RedirectResponse(
                                $this->container->get('router')->generate('page_slug', array(
                                    'path' => '/'
                                ))
                            );
                        }
                    }
                }
            }
        }

        return null;
    }
}