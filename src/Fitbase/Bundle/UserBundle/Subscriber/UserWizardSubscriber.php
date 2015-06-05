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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class UserWizardSubscriber implements EventSubscriberInterface, ContainerAwareInterface
{
    /**
     * @var
     */
    protected $container;

    /**
     * @var
     */
    protected $entityManager;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.user_wizard' => [
                ['onUserWizardEvent', 98],
                ['onUserWizardDoneEvent', -128],
            ]
        ];
    }

    /**
     * Display questionnaire to user
     * @param UserWizardEvent $event
     */
    public function onUserWizardEvent(UserWizardEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException('User object can not be empty');
        }

        $controller = new UserWizardController();
        $controller->setContainer($this->container);

        if (!($response = $controller->focusAction($this->container->get('request')))) {
            $response = $controller->focusSettingsAction($this->container->get('request'));
        }

        if ($response instanceof Response) {
            $event->setResponse($response);
            $event->stopPropagation();
        }
    }

    /**
     * Set wizart as done
     * @param UserWizardEvent $event
     */
    public function onUserWizardDoneEvent(UserWizardEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException('User object can not be empty');
        }

        if (!$user->getWizard()) {
            $user->setWizard(true);
            $this->entityManager->persist($user);
            $this->entityManager->flush($user);
        }
    }

}