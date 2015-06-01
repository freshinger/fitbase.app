<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExerciseUserTaskSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.exercise_task_done' => array('onExerciseUserTaskDoneEvent'),
            'fitbase.exercise_task_create' => array('onExerciseUserTaskCreateEvent'),
        );
    }

    /**
     * Process exercise done event
     * @param ExerciseUserEvent $event
     */
    public function onExerciseUserTaskDoneEvent(ExerciseUserEvent $event)
    {
        if (($exerciseUser = $event->getEntity())) {

            $exerciseUser->setDone(1);
            $exerciseUser->setDoneDate($this->container->get('datetime')->getDateTime('now'));

            $this->container->get('entity_manager')->persist($exerciseUser);
            $this->container->get('entity_manager')->flush($exerciseUser);
        }
    }

    /**
     * On Create exercise user event
     * @param ExerciseUserEvent $event
     */
    public function onExerciseUserTaskCreateEvent(ExerciseUserEvent $event)
    {
        if (($exerciseUser = $event->getEntity())) {

            $this->container->get('entity_manager')->persist($exerciseUser);
            $this->container->get('entity_manager')->flush($exerciseUser);
        }
    }
}