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
            'exercise_reminder_send' => array('onExerciseReminderSendEvent'),
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


                if (($exercises = $this->container->get('chooser_exercise')->choose($user, $datetime))) {
                    list($exercise0, $exercise1, $exercise2) = $exercises;

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
                }
            }
        }
    }

    /**
     *
     * @param ExerciseUserEvent $event
     */
    public function onExerciseReminderSendEvent(ExerciseUserEvent $event)
    {
        if (($exerciseUser = $event->getEntity())) {
            if (($user = $exerciseUser->getUser())) {

                $categories = array();
                if (($company = $user->getCompany())) {
                    if (($categories = $company->getParentCategories())) {
                        $categories = $company->getChildCategories();
                    }
                }

                $categoryFocus = null;
                if (($focus = $this->container->get('focus')->focus($user))) {
                    $categoryFocus = $focus->getFirstCategory();
                }


                $title = $this->container->get('translator')->trans('Ihre Fitbase Erinnerung');
                $content = $this->container->get('templating')->render('FitbaseExerciseBundle:Email:exercise.html.twig', array(
                    'user' => $exerciseUser->getUser(),
                    'categoryFocus' => $categoryFocus,
                    'categories' => $categories,
                    'exerciseUser' => $exerciseUser,
                ));

                $this->container->get('mail')->mail($user->getEmail(), $title, $content);
            }

//            $exerciseUser->setProcessed(1);
//            $this->container->get('entity_manager')->persist($exerciseUser);
//            $this->container->get('entity_manager')->flush($exerciseUser);
        }
    }
}