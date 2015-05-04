<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    protected $mailer;
    protected $translator;
    protected $templating;


    public function __construct($mailer, $templating, $translator)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_create' => array('onUserCreateEvent', -128),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserCreateEvent(UserEvent $event)
    {
        if (($user = $event->getEntity())) {

            $title = $this->translator->trans('Willkommen bei fitbase');
            $content = $this->templating->render('Email/User.html.twig', array(
                'user' => $user,
            ));

            $this->mailer->mail($user, $title, $content);
        }
    }
}