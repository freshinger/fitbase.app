<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;
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
    protected $datetime;
    protected $entityManager;

    public function __construct($entityManager, $datetime)
    {
        $this->datetime = $datetime;
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_registered' => array('onUserRegisteredEvent'),
        );
    }

    /**
     * Create new exercise for today
     * needs to skip today notification about
     * @param UserEvent $event
     */
    public function onUserRegisteredEvent(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException("User object can not be empty");
        }

        $exerciseUserReminder = new ExerciseUserReminder();
        $exerciseUserReminder->setUser($user);
        $exerciseUserReminder->setProcessed(true);
        $exerciseUserReminder->setDate($this->datetime->getDateTime('now'));

        $this->entityManager->persist($exerciseUserReminder);
        $this->entityManager->flush($exerciseUserReminder);
    }
}