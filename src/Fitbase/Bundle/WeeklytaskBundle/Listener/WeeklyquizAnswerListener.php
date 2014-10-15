<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizQuestionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizAnswerListener extends ContainerAware
{

    /**
     * On remove weekly task event
     * @param WeeklyTaskEvent $event
     */
    public function onWeeklyquizRemoveEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytaskQuiz = $event->getEntity()));

        $repositoryQuestion = $this->container->get('fitbase_entity_manager')
            ->getREpository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');

        if (($collection = $repositoryQuestion->findAllByQuiz($weeklytaskQuiz))) {
            foreach ($collection as $answer) {
                $event = new WeeklyquizAnswerEvent($answer);
                $this->container->get('event_dispatcher')->dispatch('weeklytask_answer_remove', $event);
            }
        }
    }

    /**
     * Remove all answers for removed question
     * @param WeeklyquizQuestionEvent $event
     */
    public function onWeeklyquizQuestionRemoveEvent(WeeklyquizQuestionEvent $event)
    {
        assert(($weeklytaskQuestion = $event->getEntity()));

        $repositoryAnswer = $this->container->get('fitbase_entity_manager')
            ->getREpository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');

        if (($collection = $repositoryAnswer->findAllByQuestion($weeklytaskQuestion))) {
            foreach ($collection as $answer) {
                $event = new WeeklyquizAnswerEvent($answer);
                $this->container->get('event_dispatcher')->dispatch('weeklytask_answer_remove', $event);
            }
        }
    }

    /**
     * Create answer event
     * @param WeeklyquizAnswerEvent $event
     */
    public function onWeeklyquizAnswerCreateEvent(WeeklyquizAnswerEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

    /**
     * On remove weekly task event
     * @param WeeklyTaskEvent $event
     */
    public function onWeeklyquizAnswerRemoveEvent(WeeklyquizAnswerEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->remove($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);
    }

    /**
     * On update weekly task event
     * @param WeeklyTaskEvent $event
     */
    public function onWeeklyquizAnswerUpdateEvent(WeeklyquizAnswerEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($weeklytask);
        $this->container->get('fitbase_entity_manager')->flush($weeklytask);

    }
}