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
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserWizardSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_wizard' => array('onUserWizardEvent', 128),
        );
    }

    /**
     * Display Company-specified questionnaire to user
     * @param UserWizardEvent $event
     */
    public function onUserWizardEvent(UserWizardEvent $event)
    {
        if (($user = $event->getEntity())) {

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