<?php

namespace Fitbase\Bundle\ReminderBundle\Subscriber;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserReminderSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_created' => array('onUserCreatedEvent', -128),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserCreatedEvent(UserEvent $event)
    {
        if (($user = $event->getEntity())) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryReminderUser = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

            if (!($reminder = $repositoryReminderUser->findOneByUser($user))) {

                $reminder = new ReminderUser();
                $reminder->setUser($user);
                $reminder->setPause(false);
                $event = new ReminderUserEvent($reminder);
                $this->container->get('event_dispatcher')->dispatch('reminder_create', $event);
            }
        }
    }
}