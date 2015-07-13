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
    protected $reminder;

    public function __construct($entityManager, $datetime, $reminder)
    {
        $this->datetime = $datetime;
        $this->entityManager = $entityManager;
        $this->reminder = $reminder;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.user_registered' => ['onUserRegisteredEvent', -127]
        ];
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

        $day = $this->datetime->getDateTime('now')->format('N');
        if (($collection = $this->reminder->getItemsExercise($day, $user))) {
            foreach ($collection as $reminderUserItem) {

                $date = $this->datetime->getDateTime('now');
                $date->setTime($reminderUserItem->getTime()->format('H'),
                    $reminderUserItem->getTime()->format('i'));

                $exerciseUserReminder = new ExerciseUserReminder();
                $exerciseUserReminder->setUser($user);
                $exerciseUserReminder->setDate($date);
                $exerciseUserReminder->setProcessed(true);
                $exerciseUserReminder->setProcessedDate($date);
                $exerciseUserReminder->setError(false);

                $this->entityManager->persist($exerciseUserReminder);
                $this->entityManager->flush($exerciseUserReminder);
            }
        }
    }
}