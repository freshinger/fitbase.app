<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskReminderSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'weeklyquiz_reminder_send' => array('onWeeklyquizReminderSendEvent'),
            'weeklytask_reminder_send' => array('onWeeklytaskReminderSendEvent'),
            'weeklytask_reminder_create' => array('onWeeklytaskReminderCreateEvent'),
        );
    }

    /**
     * Send quiz to user
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizReminderSendEvent(WeeklyquizUserEvent $event)
    {
        if (($weeklyquizUser = $event->getEntity())) {
            if (($user = $weeklyquizUser->getUser())) {

                $title = $this->container->get('translator')->trans('Ihr Online-Rückenschule.de Quiz');
                $content = $this->container->get('templating')->render('FitbaseWeeklytaskBundle:Email:weeklyquiz.html.twig', array(
                    'user' => $weeklyquizUser->getUser(),
                    'task' => $weeklyquizUser->getTask(),
                    'quiz' => $weeklyquizUser->getQuiz(),
                    'userQuiz' => $weeklyquizUser,
                ));

                $this->container->get('mail')->mail($user->getEmail(), $title, $content);
            }

//            $weeklyquizUser->setProcessed(1);
//            $this->container->get('entity_manager')->persist($weeklyquizUser);
//            $this->container->get('entity_manager')->flush($weeklyquizUser);
        }
    }

    /**
     * Send weekly task to user
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderSendEvent(WeeklytaskUserEvent $event)
    {
        if (($weeklytaskUser = $event->getEntity())) {
            if (($user = $weeklytaskUser->getUser())) {

                $title = $this->container->get('translator')->trans('Ihre Online-Rückenschule.de Theorie-Einheit');
                $content = $this->container->get('templating')->render('FitbaseWeeklytaskBundle:Email:weeklytask.html.twig', array(
                    'user' => $weeklytaskUser->getUser(),
                    'task' => $weeklytaskUser->getTask(),
                    'userTask' => $weeklytaskUser,

                ));

                $this->container->get('mail')->mail($user->getEmail(), $title, $content);
            }

//            $weeklytaskUser->setProcessed(1);
//            $this->container->get('entity_manager')->persist($weeklytaskUser);
//            $this->container->get('entity_manager')->flush($weeklytaskUser);
        }
    }


    /**
     * Create weeklytask reminder
     * @param WeeklytaskReminderEvent $event
     */
    public function onWeeklytaskReminderCreateEvent(WeeklytaskReminderEvent $event)
    {
        if (($reminderUserItem = $event->getEntity())) {
            if (($user = $reminderUserItem->getUser())) {

                $serviceWeeklytask = $this->container->get('weeklytask');
                if (($focus = $user->getFocus())) {

                    $hour = $reminderUserItem->getTime()->format('H');
                    $minute = $reminderUserItem->getTime()->format('i');

                    $datetime = $this->container->get('datetime')->getDateTime('now');
                    $datetime->setTime($hour, $minute);

                    $codegenerator = $this->container->get('codegenerator');
                    if (!($weeklytask = $serviceWeeklytask->getNextByFocus($user, $focus, $datetime))) {
                        if (!($weeklytask = $serviceWeeklytask->getNextRandom($user, $datetime))) {
                            return;
                        }
                    }

                    // Create reminder for weeklytask
                    $weeklytaskUser = new WeeklytaskUser();
                    $weeklytaskUser->setDone(0);
                    $weeklytaskUser->setProcessed(0);
                    $weeklytaskUser->setUser($user);
                    $weeklytaskUser->setDate($datetime);
                    $weeklytaskUser->setTask($weeklytask);
                    $weeklytaskUser->setCode($codegenerator->password(10));
                    $weeklytaskUser->setCountPoint(0);

                    $this->container->get('entity_manager')->persist($weeklytaskUser);
                    $this->container->get('entity_manager')->flush($weeklytaskUser);

                    // if a quiz for weeklytask exists
                    // create reminder for weeklyquiz
                    if (($quiz = $weeklytask->getQuiz())) {

                        $weeklyquizUser = new WeeklyquizUser();
                        $weeklyquizUser->setDone(0);
                        $weeklyquizUser->setProcessed(0);
                        $weeklyquizUser->setQuiz($quiz);
                        $weeklyquizUser->setUser($user);
                        $weeklyquizUser->setCountPoint(0);
                        $weeklyquizUser->setCode($codegenerator->password(10));
                        $weeklyquizUser->setTask($weeklytask);
                        $weeklyquizUser->setDate($datetime->modify('+1 day'));
                        $weeklyquizUser->setUserTask($weeklytaskUser);

                        $this->container->get('entity_manager')->persist($weeklyquizUser);
                        $this->container->get('entity_manager')->flush($weeklyquizUser);

                        $weeklytaskUser->setUserQuiz($weeklyquizUser);
                        $this->container->get('entity_manager')->persist($weeklytaskUser);
                        $this->container->get('entity_manager')->flush($weeklytaskUser);
                    }
                }
            }
        }
    }
}