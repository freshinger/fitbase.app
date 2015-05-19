<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/05/15
 * Time: 15:48
 */

namespace Fitbase\Bundle\FitbaseBundle\Subscriber;


use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationSubscriber extends ContainerAware implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'security.interactive_login' => array('onLoginSuccessEvent'),
        );
    }

    /**
     * On login success event
     * @param InteractiveLoginEvent $event
     */
    public function onLoginSuccessEvent(InteractiveLoginEvent $event)
    {
        $eventUser = new UserEvent($event->getAuthenticationToken()->getUser());
        $this->container->get('event_dispatcher')->dispatch('fitbase.user.signin', $eventUser);
    }
}