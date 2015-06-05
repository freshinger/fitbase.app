<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Subscriber;


use Fitbase\Bundle\FitbaseBundle\Event\UserWizardEvent;
use Fitbase\Bundle\FitbaseBundle\Subscriber\UserPageResponseSubscriber;
use Fitbase\Bundle\QuestionnaireBundle\Controller\UserWizardController;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\AssessmentUserRepeatForm;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelResponseSubscriber extends UserPageResponseSubscriber
{
    /**
     * @param FilterResponseEvent $event
     * @return mixed|void
     */
    public function onUserPageResponse(GetResponseEvent $event)
    {
        if (($user = $this->container->get('user')->current())) {

            $form = $this->container->get('form.factory')->create(new AssessmentUserRepeatForm(), new QuestionnaireUser());
            if ($this->container->get('request')->get($form->getName())) {
                $form->handleRequest($this->container->get('request'));
                if ($form->isValid()) {

                    $questionnaireUserEvent = new QuestionnaireUserEvent($form->getData()->setUser($user));
                    $this->container->get('event_dispatcher')->dispatch('fitbase.assessment_user_repeat', $questionnaireUserEvent);
                }
            }


            $managerEntity = $this->container->get('entity_manager');
            $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
            if (($questionnaireUser = $repositoryQuestionnaireUser->findOneByUserAndNotDoneAndNotPause($user))) {

                $controller = new UserWizardController();
                $controller->setContainer($this->container);

                $request = $this->container->get('request');
                if (($response = $controller->questionnaireAction($request)) !== null) {
                    $event->setResponse($response);
                    $event->stopPropagation();
                }
            }
        }
    }
}