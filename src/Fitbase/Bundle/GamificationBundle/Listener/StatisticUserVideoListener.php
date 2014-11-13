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

class StatisticUserVideoListener extends ContainerAware
{
    /**
     * Fetch user video statistic event and add points for that
     * @param \Fitbase\Bundle\StatisticBundle\Event\UserStatisticExerciseEvent $event
     */
    public function onStatisticUserVideoEvent(\Fitbase\Bundle\StatisticBundle\Event\UserStatisticExerciseEvent $event)
    {
        assert(($statistic = $event->getEntity()), 'Statistic object can not be empty');

        $userManager = $this->container->get('user');
        if (($user = $userManager->find($statistic->getUserId()))) {
            $datetime = $this->container->get('datetime');

            $GamificationUserPointlog = new GamificationUserPointlog();
            $GamificationUserPointlog->setUser($user);
            $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
            $GamificationUserPointlog->setText('Das Video wurde angeschaut');
            $GamificationUserPointlog->setCountPoint(1);

            $managerEntity = $this->container->get('entity_manager');
            $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

            $countPointTotal = $GamificationUserPointlog->getCountPoint();
            if (($GamificationUserPointlogLast = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
                $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
            }

            $GamificationUserPointlog->setCountPointTotal($countPointTotal);

            $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
            $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);
        }
    }
} 