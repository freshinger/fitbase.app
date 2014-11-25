<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizPlan;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizPlanListener extends ContainerAware
{
    /**
     * On remove weekly task event
     * @param WeeklyquizEvent $event
     */
    public function onWeeklyquizRemoveEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytaskQuiz = $event->getEntity()));

        $managerEntity = $this->container->get('entity_manager');
        $repositoryWeeklyquizPlan = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizPlan');
        if (($collectionWeeklyquizPlan = $repositoryWeeklyquizPlan->findAllByWeeklyquiz($weeklytaskQuiz))) {
            foreach ($collectionWeeklyquizPlan as $weeklytaskQuizPlan) {
                $this->container->get('entity_manager')->remove($weeklytaskQuizPlan);
                $this->container->get('entity_manager')->flush($weeklytaskQuizPlan);
            }
        }
    }

    /**
     * Process weekly task sent event
     * @param WeeklyquizPlanEvent $event
     */
    public function onWeeklyquizPlanSentEvent(WeeklyquizPlanEvent $event)
    {
        assert(($weeklytaskQuizPlan = $event->getEntity()));

        $serviceDateTime = $this->container->get('datetime');

        $weeklytaskQuizPlan->setProcessed(true);
        $weeklytaskQuizPlan->setProcessedDate($serviceDateTime->getDateTime('now'));

        $this->container->get('entity_manager')->persist($weeklytaskQuizPlan);
        $this->container->get('entity_manager')->flush($weeklytaskQuizPlan);
    }

    /**
     * Process user quiz created event
     * @param WeeklyquizUserEvent $event
     */
    public function onWeeklyquizUserCreatedEvent(WeeklyquizUserEvent $event)
    {
        assert(($weeklytaskUserQuiz = $event->getEntity()));

        $managerUser = $this->container->get('user');
        $managerEntity = $this->container->get('entity_manager');
        $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        if (($weeklytask = $repositoryWeeklytask->findOneByWeekId($weeklytaskUserQuiz->getWeekId()))) {
            $user = $managerUser->find($weeklytaskUserQuiz->getUserId());
            $serviceWeeklytask = $this->container->get('weeklytask');
            if (($dateNext = $serviceWeeklytask->getUserNextDate($user))) {
                $dateNext->modify("midnight next friday");
                $dateNext->setTime(4, 0, 0);

                $weeklytaskPlan = new WeeklyquizPlan();
                $weeklytaskPlan->setQuizId($weeklytaskUserQuiz->getQuizId());
                $weeklytaskPlan->setUserId($weeklytaskUserQuiz->getUserId());
                $weeklytaskPlan->setWeekId($weeklytaskUserQuiz->getWeekId());
                $weeklytaskPlan->setWeeklytaskId($weeklytaskUserQuiz->getWeeklytaskId());
                $weeklytaskPlan->setDate($dateNext);

                $this->container->get('entity_manager')->persist($weeklytaskPlan);
                $this->container->get('entity_manager')->flush($weeklytaskPlan);
            }
        }
    }
}