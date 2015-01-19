<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_create' => array('onUserCreateEvent', -128),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserCreateEvent(UserEvent $event)
    {
        if (($user = $event->getEntity())) {

            $title = $this->container->get('translator')->trans('Willkommen bei fitbase');
            $content = $this->container->get('templating')->render('FitbaseEmailBundle:Subscriber:user.html.twig', array(
                'user' => $user,
            ));

            $this->container->get('mail')->mail($user->getEmail(), $title, $content);
        }
    }
}