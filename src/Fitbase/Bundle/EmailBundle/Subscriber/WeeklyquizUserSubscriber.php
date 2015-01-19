<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklyquizUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'weeklyquiz_reminder_send' => array('onWeeklyquizUserSendEvent'),
        );
    }

    /**
     * Send quiz to user
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizUserSendEvent(WeeklyquizUserEvent $event)
    {
        if (($weeklyquizUser = $event->getEntity())) {
            if (($user = $weeklyquizUser->getUser())) {

                $title = $this->container->get('translator')->trans('Ihr fitbase Quiz');
                $content = $this->container->get('templating')->render('FitbaseEmailBundle:Subscriber:weeklyquiz.html.twig', array(
                    'user' => $weeklyquizUser->getUser(),
                    'task' => $weeklyquizUser->getTask(),
                    'quiz' => $weeklyquizUser->getQuiz(),
                    'userQuiz' => $weeklyquizUser,
                ));

                $this->container->get('mail')->mail($user->getEmail(), $title, $content);
            }

            $weeklyquizUser->setProcessed(1);
            $this->container->get('entity_manager')->persist($weeklyquizUser);
            $this->container->get('entity_manager')->flush($weeklyquizUser);
        }
    }
}