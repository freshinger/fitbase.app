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
     * Date time generator object
     *
     * @var
     */
    protected $datetime;

    /**
     * EntityManager object
     *
     * @var
     */
    protected $entityManager;

    /**
     * Class constructor
     *
     * @param $datetime
     * @param $entityManager
     */
    public function __construct($datetime, $entityManager)
    {
        $this->datetime = $datetime;
        $this->entityManager = $entityManager;
    }

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
     * Try to process current object,
     * deliver to user or something like that
     *
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizReminderProcessEvent(WeeklyquizUserEvent $event)
    {
        $datetime = $this->datetime;
        $entityManager = $this->entityManager;
        if (!($weeklyquizUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask object can not be empty');
        }

        $repository = $this->entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        if (($weeklyquizUserExisted = $repository->processed($weeklyquizUser))) {
            throw new \LogicException('Weeklyquiz for this date already exists');
        }

        $weeklyquizUser->setProcessed(true);
        $weeklyquizUser->setProcessedDate($datetime->getDateTime('now'));

        $entityManager->persist($weeklyquizUser);
        $entityManager->flush($weeklyquizUser);
    }

    /**
     * Process exception with current object,
     * store info about exception
     *
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizReminderExceptionEvent(WeeklyquizUserEvent $event)
    {
        $datetime = $this->datetime;
        $entityManager = $this->entityManager;
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