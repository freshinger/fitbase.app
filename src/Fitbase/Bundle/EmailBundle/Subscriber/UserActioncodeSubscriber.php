<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserActioncodeSubscriber extends ContainerAware implements EventSubscriberInterface
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
            'user_actioncode_invite' => array('onUserActioncodeInviteEvent', -128),
        );
    }

    /**
     * @param UserActioncodeEvent $event
     */
    public function onUserActioncodeInviteEvent(UserActioncodeEvent $event)
    {
        if (($actioncode = $event->getEntity())) {

            $user = new User();
            $user->setFirstname($actioncode->getFirstName());
            $user->setLastname($actioncode->getLastName());
            $user->setEmail($actioncode->getEmail());

            $context = $this->container->get('router')->getContext();
            $context->setHost($this->container->getParameter('fitbase.project.host'));
            $context->setScheme($this->container->getParameter('fitbase.project.scheme'));
            $context->setBaseUrl($this->container->getParameter('fitbase.project.url'));

            $title = $this->translator->trans('Willkommen bei fitbase');
            $content = $this->templating->render('Email/UserActioncodeInvite.html.twig', array(
                'actioncode' => $actioncode,
                'user' => $user,
            ));

            $user = (new User())->setEmail($actioncode->getEmail());
            $this->mailer->mail($user, $title, $content);
        }
    }
}