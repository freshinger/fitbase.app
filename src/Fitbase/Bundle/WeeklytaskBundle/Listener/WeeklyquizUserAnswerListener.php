<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserAnswerEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizUserAnswerListener extends ContainerAware
{
    /**
     * Store user answer
     * @param WeeklyquizUserAnswerEvent $event
     */
    public function onWeeklyquizUserAnswerCreateEvent(WeeklyquizUserAnswerEvent $event)
    {
        assert(($weeklytaskUserAnswer = $event->getEntity()));

        $this->container->get('entity_manager')->persist($weeklytaskUserAnswer);
        $this->container->get('entity_manager')->flush($weeklytaskUserAnswer);
    }
}