<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent;
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

            $title = $this->translator->trans('Willkommen bei fitbase');
            $content = $this->templating->render('Email/Subscriber/UserInvite.html.twig', array(
                'actioncode' => $actioncode,
                'company' => $actioncode->getCompany(),
                'user' => $user,
            ));

            $user = (new User())->setEmail($actioncode->getEmail());
            $this->mailer->mail($user, $title, $content);
        }
    }
}