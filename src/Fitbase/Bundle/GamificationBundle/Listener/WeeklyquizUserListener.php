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

class WeeklyquizUserListener extends ContainerAware
{
    /**
     * Fetch event for done user quiz
     * @param \Fitbase\Bundle\AufgabeBundle\Event\WeeklytaskUserQuizEvent $event
     */
    public function onWeeklytaskUserQuizDoneEvent(\Fitbase\Bundle\AufgabeBundle\Event\WeeklytaskUserQuizEvent $event)
    {
        assert(($weeklytaskUserQuiz = $event->getEntity()));

        $datetime = $this->container->get('datetime');

        $GamificationUserPointlog = new GamificationUserPointlog();
        $GamificationUserPointlog->setUser($weeklytaskUserQuiz->getUser());
        $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
        $GamificationUserPointlog->setText('Das Quiz wurde beantwortet');
        $GamificationUserPointlog->setCountPoint($weeklytaskUserQuiz->getCountPoint());

        $countPointTotal = $GamificationUserPointlog->getCountPoint();
        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryWeeklytaskQuizPlan = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

        if (($GamificationUserPointlogLast = $repositoryWeeklytaskQuizPlan->findOneLastByUser($weeklytaskUserQuiz->getUser()))) {
            $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
        }

        $GamificationUserPointlog->setCountPointTotal($countPointTotal);

        $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
        $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);
    }
} 