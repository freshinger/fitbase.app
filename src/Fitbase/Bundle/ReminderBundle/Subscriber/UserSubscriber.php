<?php

namespace Fitbase\Bundle\ReminderBundle\Subscriber;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    protected $datetime;
    protected $objectManager;

    public function __construct($objectManager, $datetime)
    {
        $this->datetime = $datetime;
        $this->objectManager = $objectManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_registered' => array('onUserRegisteredEvent'),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserRegisteredEvent(UserEvent $event)
    {
        if (($user = $event->getEntity())) {
            if (!count(($reminders = $user->getReminders()))) {

                $userReminder = new ReminderUser();
                $userReminder->setUser($user);
                $userReminder->setPause(false);
                $userReminder->setUpdate(true);

                $this->objectManager->persist($userReminder);
                $this->objectManager->flush($userReminder);

                if (($datetime = $this->datetime->getDateTime('now'))) {
                    $datetime->setTime(10, 0);

                    $entity1 = new ReminderUserItem();
                    $entity1->setDay(1);
                    $entity1->setUser($user);
                    $entity1->setReminder($userReminder);
                    $entity1->setTime($datetime);
                    $entity1->setType('exercise');
                    $this->objectManager->persist($entity1);

                    $entity2 = new ReminderUserItem();
                    $entity2->setDay(2);
                    $entity2->setUser($user);
                    $entity2->setReminder($userReminder);
                    $entity2->setTime($datetime);
                    $entity2->setType('exercise');
                    $this->objectManager->persist($entity2);

                    $entity3 = new ReminderUserItem();
                    $entity3->setDay(3);
                    $entity3->setUser($user);
                    $entity3->setReminder($userReminder);
                    $entity3->setTime($datetime);
                    $entity3->setType('exercise');
                    $this->objectManager->persist($entity3);

                    $entity4 = new ReminderUserItem();
                    $entity4->setDay(4);
                    $entity4->setUser($user);
                    $entity4->setReminder($userReminder);
                    $entity4->setTime($datetime);
                    $entity4->setType('exercise');
                    $this->objectManager->persist($entity4);

                    $entity5 = new ReminderUserItem();
                    $entity5->setDay(5);
                    $entity5->setUser($user);
                    $entity5->setReminder($userReminder);
                    $entity5->setTime($datetime);
                    $entity5->setType('exercise');
                    $this->objectManager->persist($entity5);
                    $this->objectManager->flush();
                }

                if (($datetime = $this->datetime->getDateTime('now'))) {
                    $datetime->setTime(4, 0);

                    $entity1 = new ReminderUserItem();
                    $entity1->setDay(1);
                    $entity1->setUser($user);
                    $entity1->setReminder($userReminder);
                    $entity1->setTime($datetime);
                    $entity1->setType('weeklytask');
                    $this->objectManager->persist($entity1);
                    $this->objectManager->flush($entity1);
                }
            }
        }
    }
}