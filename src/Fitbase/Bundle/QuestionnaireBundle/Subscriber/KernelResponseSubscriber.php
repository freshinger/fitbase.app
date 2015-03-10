<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Subscriber;


use Fitbase\Bundle\FitbaseBundle\Event\UserWizardEvent;
use Fitbase\Bundle\QuestionnaireBundle\Controller\UserWizardController;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelResponseSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', -20),
        );
    }

    /**
     * Process kernel response
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$event->isMasterRequest()) {
            return;
        }

        // do not capture redirects or modify XML HTTP Requests
        if ($request->isXmlHttpRequest()) {
            return;
        }

        if (($user = $this->container->get('user')->current())) {

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