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

class WeeklytaskUserListener extends ContainerAware
{
    /**
     * Process weekly task done event to add user points
     * @param \Fitbase\Bundle\AufgabeBundle\Event\WeeklytaskUserEvent $event
     */
    public function onWeeklytaskUserDoneEvent(\Fitbase\Bundle\AufgabeBundle\Event\WeeklytaskUserEvent $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $datetime = $this->container->get('datetime');

        $GamificationUserPointlog = new GamificationUserPointlog();
        $GamificationUserPointlog->setUser($weeklytaskUser->getUser());
        $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
        $GamificationUserPointlog->setText('Die Wochenaufgabe wurde bearbeitet');
        $GamificationUserPointlog->setCountPoint($weeklytaskUser->getCountPoint());

        $countPointTotal = $GamificationUserPointlog->getCountPoint();
        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryWeeklytaskQuizPlan = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

        if (($GamificationUserPointlogLast = $repositoryWeeklytaskQuizPlan->findOneLastByUser($weeklytaskUser->getUser()))) {
            $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
        }

        $GamificationUserPointlog->setCountPointTotal($countPointTotal);

        $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
        $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);
    }
} 