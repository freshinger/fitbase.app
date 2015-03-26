<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


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

class UserFocusSubscriber implements EventSubscriberInterface
{
    protected $datetime;
    protected $weeklytask;
    protected $entityManager;


    public function __construct($datetime, $weeklytask, $entityManager)
    {
        $this->datetime = $datetime;
        $this->weeklytask = $weeklytask;
        $this->entityManager = $entityManager;

    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_focus_update' => array('onUserFocusUpdateEvent', -128),
        );
    }

    /**
     * On focus update event, send weeklytask immediately
     * @param UserFocusEvent $event
     */
    public function onUserFocusUpdateEvent(UserFocusEvent $event)
    {
        if (($entity = $event->getEntity())) {
            $this->entityManager->refresh($entity);

            if (($user = $entity->getUser())) {
                if (($focusCategoryFirst = $entity->getFirstCategory())) {
                    if (($category = $focusCategoryFirst->getCategory())) {
                        // Get last category, check if
                        // current weeklytask have a different
                        // categories, than create a new weeklytask
                        if (($weeklytaskUser = $this->weeklytask->getLast($user))) {
                            if (($weeklytask = $weeklytaskUser->getTask())) {
                                if ($weeklytask->hasCategory($category)) {
                                    return;
                                }
                            }
                        }

                        $datetime = $this->datetime->getDateTime('now');
                        $this->weeklytask->create($user, $datetime);
                    }
                }
            }
        }
    }
}