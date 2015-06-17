<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\BarmerGekBundle\Subscriber;

use Fitbase\Bundle\BarmerGekBundle\Controller\RegistrationController;
use Fitbase\Bundle\BarmerGekBundle\Exception\FitbaseUserRegistrationException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => ['onKernelException', 128]
        ];
    }

    /**
     * Process custom exceptions
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof FitbaseUserRegistrationException) {

            $controller = new RegistrationController();
            $controller->setContainer($this->container);

            $event->setResponse(new RedirectResponse(
                $this->container->get('router')->generate('barmer_gek_registration', [
                    'unique' => $event->getRequest()->get('userId'),
                    'session' => $event->getRequest()->get('sessionKey'),
                ])
            ));

            $event->stopPropagation();
        }
    }
}