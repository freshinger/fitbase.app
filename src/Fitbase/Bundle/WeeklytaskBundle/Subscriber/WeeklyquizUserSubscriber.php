<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Exception\WeeklytaskLastException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklyquizUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.weeklyquiz_reminder_process' => ['onWeeklyquizReminderProcessEvent'],
            'fitbase.weeklyquiz_reminder_exception' => ['onWeeklyquizReminderExceptionEvent'],
        ];
    }

    /**
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizReminderProcessEvent(WeeklyquizUserEvent $event)
    {
        $datetime = $this->container->get('datetime');
        $entityManager = $this->container->get('entity_manager');
        if (!($weeklyquizUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask object can not be empty');
        }

        $weeklyquizUser->setProcessed(true);
        $weeklyquizUser->setProcessedDate($datetime->getDateTime('now'));

        $entityManager->persist($weeklyquizUser);
        $entityManager->flush($weeklyquizUser);
    }

    /**
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizReminderExceptionEvent(WeeklyquizUserEvent $event)
    {
        $datetime = $this->container->get('datetime');
        $entityManager = $this->container->get('entity_manager');
        if (!($weeklyquizUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask object can not be empty');
        }

        $weeklyquizUser->setProcessed(true);
        $weeklyquizUser->setError(true);
        $weeklyquizUser->setErrorDate($datetime->getDateTime('now'));

        $entityManager->persist($weeklyquizUser);
        $entityManager->flush($weeklyquizUser);
    }

}