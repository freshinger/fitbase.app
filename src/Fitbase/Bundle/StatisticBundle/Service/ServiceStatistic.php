<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 13/11/14
 * Time: 15:33
 */
namespace Fitbase\Bundle\StatisticBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceStatistic extends ContainerAware
{
    /**
     * Get user points count
     * @param $user
     * @return int
     */
    public function points($user)
    {
        $managerEntity = $this->container->get('entity_manager');
        $repositoryUserActivity = $managerEntity->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserActivity');
        if (($activity = $repositoryUserActivity->findOneLastByUser($user))) {
            return $activity->getCountPointTotal();
        }
        return 0;
    }

    /**
     * Get statistic by user
     * @param $user
     * @return array
     */
    public function statistic($user)
    {
        $managerEntity = $this->container->get('entity_manager');
        $repositoryUserActivity = $managerEntity->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserActivity');

        $datetime = $this->container->get('datetime')->getDateTime('now');
        $datetime->modify('-12 week');

        if (($statistic = $repositoryUserActivity->findAllByUserGroupByWeek($user, $datetime))) {
            foreach ($statistic as $index => $element) {
                $statistic[$index]['date'] = $this->container->get('datetime')->getDateTime($element['date']);
            }
            return $statistic;
        }
        return array();
    }

} 