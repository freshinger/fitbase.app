<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklyquizUserSubscriber implements EventSubscriberInterface
{
    protected $mailer;
    protected $translator;
    protected $templating;
    protected $objectManager;

    public function __construct($mailer, $templating, $translator, $objectManager)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
        $this->objectManager = $objectManager;
    }

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

                $title = $this->translator->trans('Ihr fitbase Quiz');
                $content = $this->templating->render('Email/Subscriber/UserWeeklyquiz.html.twig', array(
                    'user' => $weeklyquizUser->getUser(),
                    'task' => $weeklyquizUser->getTask(),
                    'quiz' => $weeklyquizUser->getQuiz(),
                    'userQuiz' => $weeklyquizUser,
                ));

                $this->mailer->mail($user, $title, $content);
            }

            $weeklyquizUser->setProcessed(1);

            $this->objectManager->persist($weeklyquizUser);
            $this->objectManager->flush($weeklyquizUser);
        }
    }
}