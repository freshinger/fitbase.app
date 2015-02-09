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
}