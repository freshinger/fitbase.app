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

class ExerciseUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.exercise_user_process' => array('onExerciseUserProcessEvent'),
        );
    }

    /**
     * @param ExerciseUserEvent $event
     */
    public function onExerciseUserProcessEvent(ExerciseUserEvent $event)
    {
        $datetime = $this->container->get('datetime');
        $entityManager = $this->container->get('entity_manager');
        if (!($exerciseUser = $event->getEntity())) {
            throw new \LogicException('Exercise user object can not be empty');
        }

        $exerciseUser->setDone(true);
        $exerciseUser->setDoneDate($datetime->getDateTime('now'));

        $entityManager->persist($exerciseUser);
        $entityManager->flush($exerciseUser);
    }
}