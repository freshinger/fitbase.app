<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExerciseUserReminderSubscriber extends ContainerAware implements EventSubscriberInterface
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
        return [
            'fitbase.exercise_reminder_create' => ['onExerciseUserReminderCreateEvent'],
            'fitbase.exercise_reminder_process' => ['onExerciseUserReminderProcessEvent'],
            'fitbase.exercise_reminder_exception' => ['onExerciseUserReminderExceptionEvent'],
        ];
    }

    /**
     *
     * @param ExerciseUserReminderEvent $event
     */
    public function onExerciseUserReminderCreateEvent(ExerciseUserReminderEvent $event)
    {
        if (!($exerciseUserReminder = $event->getEntity())) {
            throw new \LogicException('User reminder object can not be empty');
        }

        $exerciseUserReminder->setProcessed(null);
        $exerciseUserReminder->setProcessedDate(null);

        $repository = $this->entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder');
        if (!($exerciseUserReminderExisted = $repository->exists($exerciseUserReminder))) {

            $this->entityManager->persist($exerciseUserReminder);
            $this->entityManager->flush($exerciseUserReminder);
        }
    }

    /**
     * Mark user exercise reminder as processed
     * @param ExerciseUserReminderEvent $event
     */
    public function onExerciseUserReminderProcessEvent(ExerciseUserReminderEvent $event)
    {
        if (!($exerciseUserReminder = $event->getEntity())) {
            throw new \LogicException('User reminder object can not be empty');
        }

        $exerciseUserReminder->setProcessed(true);
        $this->entityManager->persist($exerciseUserReminder);
        $this->entityManager->flush($exerciseUserReminder);
    }

    /**
     * Process reminders with exceptions
     * @param ExerciseUserReminderEvent $event
     */
    public function onExerciseUserReminderExceptionEvent(ExerciseUserReminderEvent $event)
    {
        if (!($exerciseUserReminder = $event->getEntity())) {
            throw new \LogicException('User reminder object can not be empty');
        }

        $exerciseUserReminder->setError(true);
        $exerciseUserReminder->setProcessed(true);
        $this->entityManager->persist($exerciseUserReminder);
        $this->entityManager->flush($exerciseUserReminder);
    }
}