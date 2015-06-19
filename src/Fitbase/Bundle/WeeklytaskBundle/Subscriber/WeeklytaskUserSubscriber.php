<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Exception\WeeklytaskLastException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    protected $entityManager;
    protected $datetime;
    protected $eventDispatcher;
    protected $weeklytask;

    public function __construct($entityManager, $eventDispatcher, $datetime, $weeklytask)
    {
        $this->entityManager = $entityManager;
        $this->datetime = $datetime;
        $this->eventDispatcher = $eventDispatcher;
        $this->weeklytask = $weeklytask;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.weeklytask_user_done' => ['onWeeklytaskUserDoneEvent'],
            'fitbase.weeklytask_reminder_create' => [
                ['onWeeklytaskReminderCreateEvent', 127],
                ['onWeeklytaskUserDoneEvent', -127]
            ],
            'fitbase.weeklytask_reminder_exception' => ['onWeeklytaskReminderExceptionEvent'],
            'fitbase.weeklytask_reminder_process' => ['onWeeklytaskReminderProcessEvent'],
        ];
    }

    /**
     * Mark weekly task as completed
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserDoneEvent(WeeklytaskUserEvent $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $weeklytaskUser->setDone(true);
        $weeklytaskUser->setDoneDate($this->datetime->getDateTime('now'));
        $weeklytaskUser->setCountPoint(0);

        if (($weeklytask = $weeklytaskUser->getTask())) {
            $weeklytaskUser->setCountPoint($weeklytask->getCountPoint());
        }

        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);
    }

    /**
     *
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderCreateEvent(WeeklytaskUserEvent $event)
    {
        $codegenerator = $this->container->get('codegenerator');
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask user object can not be empty');
        }

        $repository = $this->entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        if (($weeklytaskUserExisted = $repository->exists($weeklytaskUser))) {
            throw new \LogicException('Weeklytask for this date already exists');
        }

        if (!($weeklytask = $this->weeklytask->choose($weeklytaskUser->getUser()))) {
            throw new WeeklytaskLastException('No available weeklytasks more');
        }

        $weeklytaskUser->setDone(0);
        $weeklytaskUser->setDoneDate(null);
        $weeklytaskUser->setError(0);
        $weeklytaskUser->setErrorDate(null);
        $weeklytaskUser->setTask($weeklytask);
        $weeklytaskUser->setCountPoint(0);
        $weeklytaskUser->setCode($codegenerator->password(10));

        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);

        if (!($quiz = $weeklytask->getQuiz())) {
            return;
        }

        $weeklyquizUser = new WeeklyquizUser();
        $weeklyquizUser->setDone(0);
        $weeklyquizUser->setProcessed($weeklytaskUser->getProcessed());
        $weeklyquizUser->setQuiz($quiz);
        $weeklyquizUser->setUser($weeklytaskUser->getUser());
        $weeklyquizUser->setCountPoint(0);
        $weeklyquizUser->setCode($codegenerator->password(10));
        $weeklyquizUser->setTask($weeklytask);
        $weeklyquizUser->setDate($weeklytaskUser->getDate()->modify('+1 day'));
        $weeklyquizUser->setUserTask($weeklytaskUser);

        $this->container->get('entity_manager')->persist($weeklyquizUser);
        $this->container->get('entity_manager')->flush($weeklyquizUser);

        $weeklytaskUser->setUserQuiz($weeklyquizUser);
        $this->container->get('entity_manager')->persist($weeklytaskUser);
        $this->container->get('entity_manager')->flush($weeklytaskUser);
    }


    /**
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderProcessEvent(WeeklytaskUserEvent $event)
    {
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask object can not be empty');
        }

        $weeklytaskUser->setProcessed(true);
        $weeklytaskUser->setProcessedDate(
            $this->datetime->getDateTime('now')
        );

        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);
    }

    /**
     *
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderExceptionEvent(WeeklytaskUserEvent $event)
    {
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask object can not be empty');
        }

        $weeklytaskUser->setError(true);
        $weeklytaskUser->setProcessed(true);
        $weeklytaskUser->setErrorDate($this->datetime->getDateTime('now'));

        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);
    }

}