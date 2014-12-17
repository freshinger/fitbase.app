<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Fitbase\Bundle\UserBundle\Event\UserSingleSignOnEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserFocusSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_created' => array('onUserCreatedEvent', -128),
        );
    }

    /**
     * Create user focus for new user
     * @param UserEvent $event
     */
    public function onUserCreatedEvent(UserEvent $event)
    {
        if (($user = $event->getEntity())) {

            $userFocus = new UserFocus();
            $userFocus->setUser($user);

            $this->container->get('entity_manager')->persist($userFocus);
            $this->container->get('entity_manager')->flush($userFocus);

            $user->setFocus($userFocus);

            $this->container->get('entity_manager')->persist($user);
            $this->container->get('entity_manager')->flush($user);


            $event = new UserFocusEvent($userFocus);
            $this->container->get('event_dispatcher')->dispatch('user_focus_created', $event);
        }

    }

}