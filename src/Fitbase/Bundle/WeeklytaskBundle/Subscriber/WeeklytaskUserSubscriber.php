<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Exception\WeeklytaskLastException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Date time generator
     * @var
     */
    protected $datetime;

    /**
     * Weeklytask service
     *
     * @var
     */
    protected $weeklytask;


    /**
     * Codegenerator service
     *
     * @var
     */
    protected $codegenerator;

    /**
     * Entty manager object
     *
     * @var
     */
    protected $entityManager;

    /**
     * Class constructor
     *
     * @param $datetime
     * @param $weeklytask
     * @param $entityManager
     */
    public function __construct($datetime, $weeklytask, $codegenerator, $entityManager)
    {
        $this->datetime = $datetime;
        $this->weeklytask = $weeklytask;
        $this->codegenerator = $codegenerator;
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     *
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
     *
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
     * Create a new reminder object
     *
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderCreateEvent(WeeklytaskUserEvent $event)
    {


        $codegenerator = $this->codegenerator;
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask user object can not be empty');
        }

//        $repository = $this->entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
//        if (($weeklytaskUserExisted = $repository->exists($weeklytaskUser))) {
//            throw new \LogicException('Weeklytask for this date already exists');
//        }

        if (is_null($weeklytaskUser->getTask())) {
            if (!($weeklytask = $this->weeklytask->choose($weeklytaskUser->getUser()))) {
                throw new WeeklytaskLastException('No available weeklytasks more');
            }
            $weeklytaskUser->setTask($weeklytask);
        }

        $weeklytaskUser->setDone(0);
        $weeklytaskUser->setDoneDate(null);
        $weeklytaskUser->setError(0);
        $weeklytaskUser->setErrorDate(null);
        $weeklytaskUser->setCountPoint(0);
        $weeklytaskUser->setCode($codegenerator->password(10));

        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);

        $dateQuiz = clone $weeklytaskUser->getDate();
        if (($weeklytask = $weeklytaskUser->getTask())
            and !($quiz = $weeklytask->getQuiz())
        ) {
            return;
        }

        $weeklyquizUser = new WeeklyquizUser();
        $weeklyquizUser->setDone(0);
        $weeklyquizUser->setDoneDate(null);
        $weeklyquizUser->setError(0);
        $weeklyquizUser->setErrorDate(null);
        $weeklyquizUser->setProcessed($weeklytaskUser->getProcessed());
        $weeklyquizUser->setProcessedDate($weeklytaskUser->getProcessedDate());
        $weeklyquizUser->setQuiz($quiz);
        $weeklyquizUser->setUser($weeklytaskUser->getUser());
        $weeklyquizUser->setCountPoint(0);
        $weeklyquizUser->setCode($codegenerator->password(10));
        $weeklyquizUser->setTask($weeklytask);
        $weeklyquizUser->setDate($dateQuiz->modify('+1 day'));
        $weeklyquizUser->setUserTask($weeklytaskUser);

        $this->entityManager->persist($weeklyquizUser);
        $this->entityManager->flush($weeklyquizUser);

        $weeklytaskUser->setUserQuiz($weeklyquizUser);
        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);
    }


    /**
     * Do something with this object and mark as processed
     * something - send an email, or any other notification
     *
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderProcessEvent(WeeklytaskUserEvent $event)
    {
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask object can not be empty');
        }

        $repository = $this->entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        if (($weeklytaskUserExisted = $repository->processed($weeklytaskUser))) {
            throw new \LogicException('Weeklytask for this date already exists');
        }

        $weeklytaskUser->setProcessed(true);
        $weeklytaskUser->setProcessedDate(
            $this->datetime->getDateTime('now')
        );

        $this->entityManager->persist($weeklytaskUser);
        $this->entityManager->flush($weeklytaskUser);
    }

    /**
     * Process exception with current object,
     * store information about this exception
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