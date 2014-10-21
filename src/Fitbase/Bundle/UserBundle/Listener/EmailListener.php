<?php
namespace Fitbase\Bundle\UserBundle\Listener;

use Fitbase\Bundle\UserBundle\Event\MenteeEvent;
use Fitbase\Bundle\UserBundle\Event\RegisteredEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Event\UserImportEvent;
use Fitbase\Bundle\UserBundle\Event\UserMedimouseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class EmailListener extends ContainerAware
{
    /**
     * Send email to imported user
     * @param UserImportEvent $event
     */
    public function onUserImportedEvent(UserImportEvent $event)
    {
        assert(($userImport = $event->getEntity()));

        assert(($host = $this->container->get('request')->getHttpHost()));

        $email = $userImport->getEmail();
        $title = "Willkommen bei $host";

        $templating = $this->container->get('templating');
        $content = $templating->render('FitbaseUserBundle:Email:import.html.twig', array(
            'host' => $host,
            'user' => $userMedimouse,
            'firstName' => $userImport->getNameFirst(),
            'lastName' => $userImport->getNameLast(),
            'email' => $userImport->getEmail(),
            'text' => $userImport->getText(),
            'displayName' => $userImport->getNameDisplay(),
            'password' => $userImport->getPassword(),
        ));

        $attachments = array();
        if (($attachment1 = $userImport->getAttach1())) {
            array_push($attachments, $attachment1);
        }
        if (($attachment2 = $userImport->getAttach2())) {
            array_push($attachments, $attachment2);
        }
        if (($attachment3 = $userImport->getAttach3())) {
            array_push($attachments, $attachment3);
        }

        $this->container->get('fitbase_mailer')->mail($email, $title, $content, $attachments);
    }


    /**
     *
     * @param UserMedimouseEvent $event
     */
    public function onUserMedimouseCreatedEvent(UserMedimouseEvent $event)
    {
        assert(($userMedimouse = $event->getEntity()));
        assert(($host = $this->container->get('request')->getHttpHost()));

        $email = $userMedimouse->getEmail();
        $title = "Willkommen bei $host";

        $templating = $this->container->get('templating');
        $content = $templating->render('FitbaseUserBundle:Email:import.html.twig', array(
            'host' => $host,
            'user' => $userMedimouse,
            'firstName' => $userMedimouse->getNameFirst(),
            'lastName' => $userMedimouse->getNameLast(),
            'email' => $userMedimouse->getEmail(),
            'displayName' => $userMedimouse->getDisplayName(),
            'password' => $userMedimouse->getPassword(),
        ));

        $this->container->get('fitbase_mailer')->mail($email, $title, $content);
    }
}