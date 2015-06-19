<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklyquizUserSubscriber implements EventSubscriberInterface
{
    protected $mailer;
    protected $translator;
    protected $templating;
    protected $entityManager;

    public function __construct($mailer, $templating, $translator, $entityManager)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.weeklyquiz_reminder_process' => array('onWeeklyquizUserSendEvent'),
        );
    }

    /**
     * Send quiz to user
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizUserSendEvent(WeeklyquizUserEvent $event)
    {
        if (!($weeklyquizUser = $event->getEntity())) {
            throw new \LogicException('Weeklyquiz object can not be empty');
        }

        if (!($user = $weeklyquizUser->getUser())) {
            throw new \LogicException('User object can not be empty');
        }

        $repository = $this->entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        if (($weeklyquizUserExisted = $repository->processed($weeklyquizUser))) {
            throw new \LogicException('Weeklyquiz for this date already exists');
        }

        $title = $this->translator->trans('Ihr fitbase Quiz');
        $content = $this->templating->render('Email/Subscriber/UserWeeklyquiz.html.twig', array(
            'user' => $user,
            'company' => $user->getCompany(),
            'task' => $weeklyquizUser->getTask(),
            'quiz' => $weeklyquizUser->getQuiz(),
            'userQuiz' => $weeklyquizUser,
        ));

        $this->mailer->mail($user, $title, $content);
    }
}