<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizPlanEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;

class WeeklyquizUserListener extends ContainerAware
{

    /**
     * Mark weekly quiz as done
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizUserDoneEvent(WeeklyquizUserEvent $event)
    {
        assert(($weeklyquizUser = $event->getEntity()));

        if (($weeklyquiz = $weeklyquizUser->getQuiz())) {

            $weeklyquizUser->setDone(true);
            $weeklyquizUser->setCountPoint($weeklyquiz->getCountPoint());
            $weeklyquizUser->setDoneDate($this->container->get('datetime')->getDateTime('now'));

            $this->container->get('entity_manager')->persist($weeklyquizUser);
            $this->container->get('entity_manager')->flush($weeklyquizUser);
        }
    }

    /**
     * Plan user quiz event
     * @param UserEvent $event
     */
    public function onWeeklyquizUserPlanEvent(UserEvent $event)
    {
        assert(($user = $event->getEntity()));

        $logger = $this->container->get('logger');
        $codegenerator = $this->container->get('codegenerator');
        $entityManager = $this->container->get('entity_manager');
        $serviceDateTime = $this->container->get('datetime');

        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        $repositoryWeeklytaskPlan = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan');
        $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
        $repositoryWeeklyquizPlan = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizPlan');


        // Try to find last processed weekly task plan
        // if not found, we have not to send weekly quiz
        $weeklytaskPlan = $repositoryWeeklytaskPlan->findOneLastByProcessedAndUser($user);
        if (!is_object($weeklytaskPlan)) {
            $logger->info('Weekly quiz, processed weekly task plan not found', array($user->getId()));
            return;
        }

        // Try to find existed weekly quiz plan
        // if found, we have not to create new one
        $weeklytaskQuizPlanExisted = $repositoryWeeklyquizPlan->findOneByUserAndWeekId($user, $weeklytaskPlan->getWeekId());
        if (is_object($weeklytaskQuizPlanExisted)) {
            $logger->info('Weekly quiz, weekly quiz plan already exists', array($weeklytaskQuizPlanExisted->getId()));
            return;
        }

        // Try to find weekly quiz record
        // if not exists, not quiz to send
        if (!($weeklytaskQuiz = $repositoryWeeklyquiz->findOneByWeeklytaskId($weeklytaskPlan->getWeeklytaskId()))) {
            $logger->info('Weekly quiz, weekly task not found', array($weeklytaskPlan->getWeeklytaskId()));
            return;
        }

        $weeklytaskUserQuiz = new WeeklyquizUser();
        $weeklytaskUserQuiz->setQuizId($weeklytaskQuiz->getId());
        $weeklytaskUserQuiz->setUserId($weeklytaskPlan->getUserId());
        $weeklytaskUserQuiz->setWeekId($weeklytaskPlan->getWeekId());
        $weeklytaskUserQuiz->setWeeklytaskId($weeklytaskPlan->getWeeklytaskId());
        $weeklytaskUserQuiz->setCountPoint($weeklytaskQuiz->getCountPoint());
        $weeklytaskUserQuiz->setCode($codegenerator->code(20));

        $logger->info('Weekly quiz, send event to create user quiz', array($weeklytaskPlan->getWeeklytaskId()));

        $this->container->get('event_dispatcher')
            ->dispatch('weeklytask_user_quiz_create',
                new WeeklyquizUserEvent($weeklytaskUserQuiz));

        $logger->info('Weekly quiz, send event to created user quiz', array($weeklytaskPlan->getWeeklytaskId()));

        $this->container->get('event_dispatcher')
            ->dispatch('weeklytask_user_quiz_created',
                new WeeklyquizUserEvent($weeklytaskUserQuiz));
    }

    /**
     * Create weekly task object
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizUserCreateEvent(WeeklyquizUserEvent $event)
    {
        assert(($weeklytaskUserQuiz = $event->getEntity()));

        $this->container->get('entity_manager')->persist($weeklytaskUserQuiz);
        $this->container->get('entity_manager')->flush($weeklytaskUserQuiz);
    }

    /**
     * Process send event
     * @param UserEvent $event
     */
    public function onWeeklyquizUserSendEvent(UserEvent $event)
    {
        assert(($user = $event->getEntity()));

        $logger = $this->container->get('logger');
        $repositoryWeeklyquizPlan = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizPlan');

        $serviceDateTime = $this->container->get('datetime');

        if (($collection = $repositoryWeeklyquizPlan->findAllByUserAndDateAndNotProcessed($user, $serviceDateTime->getDateTime('now')))) {
            foreach ($collection as $weeklytaskQuizPlan) {

                $weeklytaskQuizPlanEvent = new WeeklyquizPlanEvent($weeklytaskQuizPlan);
                $this->container->get('event_dispatcher')
                    ->dispatch('weeklytask_quiz_plan_send', $weeklytaskQuizPlanEvent);
            }
        }
    }

    /**
     * On update weekly task quiz
     * @param WeeklyquizEvent $event
     */
    public function onWeeklyquizUpdateEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytaskQuiz = $event->getEntity()));

        $repositoryWeeklyquizUser = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

        $collectionWeeklyquizUser = $repositoryWeeklyquizUser->findAllByWeeklyquiz($weeklytaskQuiz);
        if (count($collectionWeeklyquizUser)) {
            foreach ($collectionWeeklyquizUser as $weeklytaskUserQuiz) {

                $weeklytaskUserQuiz->setWeeklytaskId($weeklytaskQuiz->getWeeklytaskId());
                $weeklytaskUserQuiz->setCountPoint($weeklytaskQuiz->getCountPoint());

                $this->container->get('entity_manager')->persist($weeklytaskUserQuiz);
                $this->container->get('entity_manager')->flush($weeklytaskUserQuiz);
            }
        }
    }
}