<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskUserSubscriber implements EventSubscriberInterface
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
            'fitbase.weeklytask_reminder_process' => array('onWeeklytaskUserSendEvent'),
        );
    }

    /**
     * Send weekly task to user
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserSendEvent(WeeklytaskUserEvent $event)
    {
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask user can not be empty');
        }

        if (!($user = $weeklytaskUser->getUser())) {
            throw new \LogicException('User object can not be empty');
        }

        $repository = $this->objectManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        if (($weeklytaskUserExisted = $repository->processed($weeklytaskUser))) {
            throw new \LogicException('Weeklytask for this date already exists');
        }

        $title = $this->translator->trans('Ihre fitbase Infoeinheit');
        $content = $this->templating->render('Email/Subscriber/UserWeeklytask.html.twig', array(
            'user' => $user,
            'company' => $user->getCompany(),
            'task' => $weeklytaskUser->getTask(),
            'userTask' => $weeklytaskUser,
        ));

        $this->mailer->mail($user, $title, $content);
    }
}