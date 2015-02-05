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
            'weeklytask_reminder_send' => array('onWeeklytaskUserSendEvent'),
        );
    }

    /**
     * Send weekly task to user
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserSendEvent(WeeklytaskUserEvent $event)
    {
        if (($weeklytaskUser = $event->getEntity())) {

            if (($user = $weeklytaskUser->getUser())) {

                $title = $this->translator->trans('Ihre fitbase Infoeinheit');
                $content = $this->templating->render('FitbaseEmailBundle:Subscriber:weeklytask.html.twig', array(
                    'user' => $weeklytaskUser->getUser(),
                    'task' => $weeklytaskUser->getTask(),
                    'userTask' => $weeklytaskUser,

                ));

                $this->mailer->mail($user->getEmail(), $title, $content);
            }

            $weeklytaskUser->setProcessed(1);

            $this->objectManager->persist($weeklytaskUser);
            $this->objectManager->flush($weeklytaskUser);
        }
    }
}