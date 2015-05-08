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

abstract class UserPageResponseSubscriber extends ContainerAware implements EventSubscriberInterface
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
     * @param FilterResponseEvent $event
     * @return mixed
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (($request = $event->getRequest())) {
            if ($event->isMasterRequest() and !$request->isXmlHttpRequest()) {
                // TODO: remove hard-code
                // do nothing on theme-css controllers
                if (strpos($request->get('_route'), 'theme') == NULL) {
                    return $this->onUserPageResponse($event);
                }
            }
        }
    }

    /**
     * @param FilterResponseEvent $event
     * @return mixed
     */
    abstract function onUserPageResponse(FilterResponseEvent $event);

}