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
use Symfony\Component\HttpKernel\KernelEvents;

class KernelResponseSubscriber extends ContainerAware implements EventSubscriberInterface
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
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', -10),
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

        if (($user = $this->serviceUser->current())) {
            if (!$user->getWizard()) {

                $eventWizard = new UserWizardEvent($user);
                $this->eventDispatcher->dispatch('user_wizard', $eventWizard);

                if (($response = $eventWizard->getResponse())) {

                    $event->setResponse($eventWizard->getResponse());
                    $event->stopPropagation();
                }
            }
        }
    }
}