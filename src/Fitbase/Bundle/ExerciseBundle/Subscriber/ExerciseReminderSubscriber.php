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


                    if (($focus = $user->getFocus())) {
                        if (($categories = $this->container->get('focus')->categories())) {
                            if (($focusCategoryFirst = $focus->getFirstCategory())) {

                                $entity = new ExerciseUser();
                                $entity->setDone(0);
                                $entity->setUser($user);
                                $entity->setProcessed(0);
                                $entity->setDate($datetime);

                                $exerciseManager = $this->container->get('fitbase.orm.exercise_manager');
                                $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 0);
                                $entity->setExercise0($exerciseManager->findOneByCategoriesAndType($categories, $types));

                                $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 1);
                                $entity->setExercise1($exerciseManager->findOneByCategoriesAndType($categories, $types));

                                $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 2);
                                $entity->setExercise2($exerciseManager->findOneByCategoriesAndType($categories, $types));

                                $this->container->get('entity_manager')->persist($entity);
                                $this->container->get('entity_manager')->flush($entity);

                                $this->container->get('logger')->info("[exercise][planner] Done for user: {$user->getId()}, date: {$datetime->format("d.n.Y")}");
                            }
                        }
                    }


                    return;
                }
            }
        }
    }
}