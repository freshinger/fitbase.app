<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizQuestionEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizQuestionListener extends ContainerAware
{

    /**
     * On remove weekly task event
     * @param WeeklyTaskEvent $event
     */
    public function onWeeklyquizRemoveEvent(WeeklyquizEvent $event)
    {
        assert(($weeklytaskQuiz = $event->getEntity()));

        $repositoryQuestion = $this->container->get('entity_manager')
            ->getREpository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');

        if (($collection = $repositoryQuestion->findAllByQuiz($weeklytaskQuiz))) {
            foreach ($collection as $question) {
                $event = new WeeklyquizQuestionEvent($question);
                $this->container->get('event_dispatcher')->dispatch('weeklytask_question_remove', $event);
            }
        }
    }

    /**
     * Create new question event
     * @param WeeklyquizQuestionEvent $event
     */
    public function onWeeklyquizQuestionCreateEvent(WeeklyquizQuestionEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('entity_manager')->persist($weeklytask);
        $this->container->get('entity_manager')->flush($weeklytask);
    }

    /**
     * On remove weekly task event
     * @param WeeklyTaskEvent $event
     */
    public function onWeeklyquizQuestionRemoveEvent(WeeklyquizQuestionEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('entity_manager')->remove($weeklytask);
        $this->container->get('entity_manager')->flush($weeklytask);
    }

    /**
     * On update weekly task event
     * @param WeeklyTaskEvent $event
     */
    public function onWeeklyquizQuestionUpdateEvent(WeeklyquizQuestionEvent $event)
    {
        assert(($weeklytask = $event->getEntity()));

        $this->container->get('entity_manager')->persist($weeklytask);
        $this->container->get('entity_manager')->flush($weeklytask);

    }

}