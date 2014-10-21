<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:22 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyquizUserAnswerListener extends ContainerAware
{
    /**
     * Fetch user answer create event and add user points for that
     * @param \Fitbase\Bundle\AufgabeBundle\Event\WeeklytaskUserAnswerEvent $event
     */
    public function onWeeklytaskUserAnswerCreateEvent(\Fitbase\Bundle\AufgabeBundle\Event\WeeklytaskUserAnswerEvent $event)
    {
        assert(($weeklytaskUserAnswer = $event->getEntity()));

        $datetime = $this->container->get('datetime');

        $GamificationUserPointlog = new GamificationUserPointlog();
        $GamificationUserPointlog->setUser($weeklytaskUserAnswer->getUser());
        $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
        $GamificationUserPointlog->setText('Eine Antwort auf das Quiz');
        $GamificationUserPointlog->setCountPoint($weeklytaskUserAnswer->getCountPoint());

        $countPointTotal = $GamificationUserPointlog->getCountPoint();
        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryWeeklytaskQuizPlan = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

        if (($GamificationUserPointlogLast = $repositoryWeeklytaskQuizPlan->findOneLastByUser($weeklytaskUserAnswer->getUser()))) {
            $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
        }

        $GamificationUserPointlog->setCountPointTotal($countPointTotal);

        $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
        $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);
    }
} 