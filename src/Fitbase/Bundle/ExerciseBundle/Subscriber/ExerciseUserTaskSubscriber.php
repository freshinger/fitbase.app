<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserTaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExerciseUserTaskSubscriber extends ContainerAware implements EventSubscriberInterface
{
    protected $entityManager;
    protected $datetime;

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
            'fitbase.exercise_user_task_process' => array('onExerciseUserTaskProcessEvent'),
            'fitbase.exercise_user_task_create' => array('onExerciseUserTaskCreateEvent'),
        );
    }

    /**
     * @param ExerciseUserTaskEvent $event
     */
    public function onExerciseUserTaskProcessEvent(ExerciseUserTaskEvent $event)
    {
        if (!($exerciseUserTask = $event->getEntity())) {
            throw new \LogicException("Exercise user task not found");
        }

        if ($exerciseUserTask->getExercise0Done() and
            $exerciseUserTask->getExercise1Done() and
            $exerciseUserTask->getExercise2Done()) {

            $exerciseUserTask->setDone(true);
            $exerciseUserTask->setDoneDate(
                $this->datetime->getDateTime('now')
            );
        }

        $this->entityManager->persist($exerciseUserTask);
        $this->entityManager->flush($exerciseUserTask);
    }

    /**
     * @param ExerciseUserTaskEvent $event
     */
    public function onExerciseUserTaskCreateEvent(ExerciseUserTaskEvent $event)
    {
        if (!($exerciseUserTask = $event->getEntity())) {
            throw new \LogicException("Exercise user task not found");
        }

        $this->entityManager->persist($exerciseUserTask);
        $this->entityManager->flush($exerciseUserTask);
    }
}