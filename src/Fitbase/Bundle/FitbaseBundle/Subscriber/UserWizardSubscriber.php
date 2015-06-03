<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\FitbaseBundle\Subscriber;


use Fitbase\Bundle\FitbaseBundle\Event\UserWizardEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserWizardSubscriber extends UserPageResponseSubscriber implements EventSubscriberInterface
{
    protected $serviceUser;
    protected $eventDispatcher;

    public function __construct($serviceUser, $eventDispatcher)
    {
        $this->serviceUser = $serviceUser;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents();
    }

    /**
     * @param GetResponseEvent $event
     * @return mixed|void
     */
    public function onUserPageResponse(GetResponseEvent $event)
    {
        if (($user = $this->serviceUser->current())) {

            // Wizard already done
            if ($user->getWizard()) {
                return;
            }

            $eventWizard = new UserWizardEvent($user);
            $this->eventDispatcher->dispatch('fitbase.user_wizard', $eventWizard);

            if (($response = $eventWizard->getResponse())) {
                $event->setResponse($eventWizard->getResponse());
                $event->stopPropagation();
            }
        }
    }
}