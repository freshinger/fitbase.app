<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExerciseSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.exercise_process' => array('onExerciseProcessEvent'),
        );
    }

    /**
     * @param ExerciseEvent $event
     */
    public function onExerciseProcessEvent(ExerciseEvent $event)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException("User object can not be empty");
        }

        $datetime = $this->container->get('datetime');
        if (!($exercise = $event->getEntity())) {
            throw new \LogicException("Exercise object can not be empty");
        }

        $exerciseUser = new ExerciseUser();
        $exerciseUser->setUser($user);
        $exerciseUser->setExercise($exercise);
        $exerciseUser->setDone(true);
        $exerciseUser->setProcessed(true);
        $exerciseUser->setDate($datetime->getDateTime('now'));
        $exerciseUser->setDoneDate($datetime->getDateTime('now'));
        $exerciseUser->setProcessedDate($datetime->getDateTime('now'));

        $event = new ExerciseUserEvent($exerciseUser);
        $this->container->get('event_dispatcher')->dispatch('fitbase.exercise_user_process', $event);
    }
}