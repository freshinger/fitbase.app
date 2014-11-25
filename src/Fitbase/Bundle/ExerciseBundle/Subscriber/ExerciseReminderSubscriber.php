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
     * Send weekly task to user
     * @param WeeklytaskUserEvent $event
     */
    public function onExerciseReminderSendEvent(ExerciseUserEvent $event)
    {
        if (($exerciseUser = $event->getEntity())) {

            if (($user = $exerciseUser->getUser())) {

                $title = $this->container->get('translator')->trans('Ihre Online-Rückenschule.de Erinnerung');
                $content = $this->container->get('templating')->render('FitbaseExerciseBundle:Email:exercise.html.twig', array(
                    'user' => $exerciseUser->getUser(),
                ));

                $this->container->get('mail')->mail($user->getEmail(), $title, $content);
            }

////            $exerciseUser->setProcessed(1);
////            $this->container->get('entity_manager')->persist($exerciseUser);
////            $this->container->get('entity_manager')->flush($exerciseUser);
        }
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
                if (!$repositoryExerciseUser->findOneByUserAndDateTime($user, $datetime)) {

                    $entity = new ExerciseUser();
                    $entity->setDate(0);
                    $entity->setProcessed(0);
                    $entity->setUser($user);
                    $entity->setDate($datetime);

                    $this->container->get('entity_manager')->persist($entity);
                    $this->container->get('entity_manager')->flush($entity);
                }
            }
        }
    }
}