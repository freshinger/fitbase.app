<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\UserBundle\Subscriber;

use Fitbase\Bundle\FitbaseBundle\Event\UserWizardEvent;
use Fitbase\Bundle\UserBundle\Controller\UserWizardController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class UserWizardSubscriber implements EventSubscriberInterface
{
    protected $container;
    protected $request;
    protected $entityManager;

    public function __construct($container, $request, $entityManager)
    {
        $this->request = $request;
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_wizard' => array('onUserWizardEvent', 98),
        );
    }

    /**
     * Display questionnaire to user
     * @param UserWizardEvent $event
     */
    public function onUserWizardEvent(UserWizardEvent $event)
    {
        if (($user = $event->getEntity())) {

            $controller = new UserWizardController();
            $controller->setContainer($this->container);

            if (($response = $controller->focusAction($this->request)) == null) {
                if (($response = $controller->focusSettingsAction($this->request)) == null) {

                    //TODO: more wizards!!!!!
                }
            }

            if ($response instanceof Response) {
                $event->setResponse($response);
                $event->stopPropagation();
                return;
            }

            if (!$user->getWizard()) {
                $user->setWizard(1);
                $this->entityManager->persist($user);
                $this->entityManager->flush($user);
            }
        }
    }
}