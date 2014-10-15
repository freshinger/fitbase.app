<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizAnswerEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserAnswerEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizUserAnswerListener extends ContainerAware
{
    public function onWeeklyquizUserAnswerCreateEvent(WeeklyquizUserAnswerEvent $event)
    {
        assert(($weeklytaskUserAnswer = $event->getEntity()));

        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryWeeklyquizUserAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer');

        $weeklytaskUserAnswerExisted = $repositoryWeeklyquizUserAnswer->findOneByUserAndQuizAndQuestion(
            $weeklytaskUserAnswer->getUser(),
            $weeklytaskUserAnswer->getQuiz(),
            $weeklytaskUserAnswer->getQuestion()
        );

        if (empty($weeklytaskUserAnswerExisted)) {

            $this->container->get('fitbase_entity_manager')->persist($weeklytaskUserAnswer);
            $this->container->get('fitbase_entity_manager')->flush($weeklytaskUserAnswer);
        }
    }
}