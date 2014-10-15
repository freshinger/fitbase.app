<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizListener extends ContainerAware
{
    public function onWeeklyquizCreateEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $weeklytask->setDescription(stripslashes($weeklytask->getDescription()));

        $this->container->get('fitbase_entity_manager')->persist($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

    /**
     * On remove weekly task event
     * @param WeeklyquizEvent $event
     */
    public function onWeeklyquizRemoveEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->remove($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

    /**
     * On update weekly task event
     * @param WeeklytaskEvent $event
     */
    public function onWeeklytaskUpdateEvent(WeeklytaskEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $repositoryWeeklyquiz = $this->container->get('fitbase_entity_manager')
            ->getREpository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

        if (($quizId = $weeklytask->getQuizId())) {
            if (($weeklytaskQuiz = $repositoryWeeklyquiz->find($quizId))) {
                $weeklytaskQuiz->setWeeklytaskId($weeklytask->getId());
                $this->container->get('fitbase_entity_manager')->persist($weeklytaskQuiz);
                $this->container->get('fitbase_entity_manager')->flush($weeklytaskQuiz);
            }
        }
    }

    /**
     * On update weekly task quiz
     * @param WeeklyquizEvent $event
     */
    public function onWeeklyquizUpdateEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $weeklytask->setDescription(stripslashes($weeklytask->getDescription()));


        $this->container->get('fitbase_entity_manager')->persist($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

}