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

class ExerciseReminderSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'exercise_reminder_create' => array('onExerciseReminderCreateEvent'),
        );
    }

    /**
     *
     * @param ExerciseReminderEvent $event
     */
    public function onExerciseReminderCreateEvent(ExerciseReminderEvent $event)
    {
        if (($reminderUserItem = $event->getEntity())) {
            if (($user = $reminderUserItem->getUser())) {

                $hour = $reminderUserItem->getTime()->format('H');
                $minute = $reminderUserItem->getTime()->format('i');

                $datetime = $this->container->get('datetime')->getDateTime('now');
                $datetime->setTime($hour, $minute);

                $entityManager = $this->container->get('entity_manager');
                $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');

                if (!($exerciseUser = $repositoryExerciseUser->findOneByUserAndDateTime($user, $datetime))) {

                    $this->container->get('logger')->info("[exercise][planner] Create for user: {$user->getId()}, date: {$datetime->format("d.n.Y")}");

                    $exercise0 = null;
                    $exercise1 = null;
                    $exercise2 = null;

                    // Get 3 videos random, but with respect to user focus
                    // and create a exercise for user with 3 videos
                    if (($focus = $user->getFocus())) {
                        if (($focusCategory = $focus->getFirstCategory())) {
                            if (($collection = $this->container->get('exercise.task')->random($user, $focusCategory->getCategory()))) {
                                list($exercise0, $exercise1, $exercise2) = $collection;
                            }
                        }
                    }

                    $entity = new ExerciseUser();
                    $entity->setDone(0);
                    $entity->setProcessed(0);
                    $entity->setUser($user);
                    $entity->setDate($datetime);
                    $entity->setExercise0($exercise0);
                    $entity->setExercise1($exercise1);
                    $entity->setExercise2($exercise2);

                    $this->container->get('entity_manager')->persist($entity);
                    $this->container->get('entity_manager')->flush($entity);
                    return;
                }
            }
        }
    }
}