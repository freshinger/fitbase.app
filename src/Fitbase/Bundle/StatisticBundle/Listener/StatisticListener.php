<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/23/14
 * Time: 10:54 AM
 */

namespace Fitbase\Bundle\StatisticBundle\Listener;


use Fitbase\Bundle\StatisticBundle\Entity\UserStatistic;
use Fitbase\Bundle\StatisticBundle\Event\UserLogEvent;
use Fitbase\Bundle\StatisticBundle\Event\UserStatisticVideoEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class StatisticListener extends ContainerAware
{
    /**
     * Process user creation on Statistic
     * @param $event
     */
    public function onUserCreatedEvent(UserEvent $event)
    {
        assert(($user = $event->getEntity()));

        $userStatistic = new UserStatistic();
        $userStatistic->setUser($user);
        $userStatistic->setCountLogin(0);
        $userStatistic->setCountVideo(0);
        $userStatistic->setCountWeeklyTask(0);
        $userStatistic->setUserAgent(null);
        $userStatistic->setLoggedAt(null);

        $this->container->get('fitbase_entity_manager')->persist($userStatistic);
        $this->container->get('fitbase_entity_manager')->flush($userStatistic);
    }

    /**
     * Process user statistic export event
     * @param UserEvent $event
     */
    public function onUserStatisticExportEvent(UserEvent $event)
    {
        assert(($user = $event->getEntity()));

        $userStatisticRepository = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic');

        if (!($userStatistic = $userStatisticRepository->findOneBy(array('user' => $user)))) {

            $taskCountProcessed = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklyTasks')
                ->getTaskCountProcessed($user);

            $videoCountProcessed = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticVideo')
                ->getUserViewCountTotal($user->getId());

            $userStatistic = new UserStatistic();
            $userStatistic->setUser($user);
            $userStatistic->setCountLogin($user->getMetaValue('user_login_count'));
            $userStatistic->setUserAgent($user->getMetaValue('user_last_login_browser'));
            $userStatistic->setCountVideo($videoCountProcessed);
            $userStatistic->setCountWeeklyTask($taskCountProcessed);
            if (($datetime = $user->getMetaValue('user_last_login'))) {
                $dateTime = $this->container->get('datetime');
                $userStatistic->setLoggedAt($dateTime->getDateTime($datetime));
            }

            $this->container->get('fitbase_entity_manager')->persist($userStatistic);
            $this->container->get('fitbase_entity_manager')->flush($userStatistic);
        }
    }

    /**
     * Store statistic on send event
     * @param $event
     */
    public function onStatisticWeeklyTaskEvent($event)
    {
        assert(is_object(($task = $event->getEntity())));

        $managerUser = $this->container->get('fitbase_manager.user');

        if (($user = $managerUser->find($task->getUserId()))) {

            $userStatisticRepository = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic');

            if (($userStatistic = $userStatisticRepository->findOneBy(array('user' => $user)))) {

                $weeklyTaskRepository = $this->container->get('fitbase_entity_manager')
                    ->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklyTasks');

                $userStatistic->setCountWeeklyTask(
                    $weeklyTaskRepository->getTaskCount($user)
                );

                $this->container->get('fitbase_entity_manager')->persist($userStatistic);
                $this->container->get('fitbase_entity_manager')->flush($userStatistic);
            }
        }
    }


    /**
     * Process weeekly task
     * @param $event
     */
    public function onStatisticWeeklyTaskProcessedEvent($event)
    {
        assert(($user = $event->getUser()));
        assert(($post = $event->getEntity()));

        $userStatisticRepository = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic');

        if (($userStatistic = $userStatisticRepository->findOneBy(array('user' => $user)))) {

            $weeklyTaskRepository = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklyTasks');

            $userStatistic->setCountWeeklyTaskProcessed(
                $weeklyTaskRepository->getTaskCountProcessed($user)
            );

            $this->container->get('fitbase_entity_manager')->persist($userStatistic);
            $this->container->get('fitbase_entity_manager')->flush($userStatistic);
        }
    }

    /**
     * Refresh user wochenaufgabe statistic
     * @param $event
     */
    public function onStatisticWeeklyTaskStatisticEvent($event)
    {
        assert(($user = $event->getEntity()));

        $userStatisticRepository = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic');

        if (($userStatistic = $userStatisticRepository->findOneBy(array('user' => $user)))) {

            $weeklyTaskRepository = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\AufgabeBundle\Entity\WeeklyTasks');

            $userStatistic->setCountWeeklyTask(
                $weeklyTaskRepository->getTaskCount($user)
            );

            $userStatistic->setCountWeeklyTaskProcessed(
                $weeklyTaskRepository->getTaskCountProcessed($user)
            );

            $this->container->get('fitbase_entity_manager')->persist($userStatistic);
            $this->container->get('fitbase_entity_manager')->flush($userStatistic);
        }
    }

    /**
     * Process statistic event
     * TODO: save into table to show a statistic in a time
     * @param UserLogEvent $event
     */
    public function onStatisticLoginEvent(UserLogEvent $event)
    {
        assert(($statistic = $event->getEntity()), 'Statistic object can not be empty');

        $dateTime = $this->container->get('datetime');
        $userManager = $this->container->get('fitbase_manager.user');
        $userMetaManager = $this->container->get('fitbase_manager.user_meta');

        if (($user = $userManager->find($statistic->getUserId()))) {

            $loginCount = $user->getMetaValue('user_login_count');

            $userMetaManager->setUserMeta($user, 'user_login_count', ($loginCount + 1));
            $userMetaManager->setUserMeta($user, 'user_last_login', $dateTime->getDateTime('now')->format('Y-m-d h:i:s'));
            $userMetaManager->setUserMeta($user, 'user_last_login_browser', $statistic->getUserAgent());

            $userStatisticRepository = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic');

            if (($userStatistic = $userStatisticRepository->findOneBy(array('user' => $user)))) {

                $userStatistic->setLoggedAt($dateTime->getDateTime('now'));
                $userStatistic->setUserAgent($statistic->getUserAgent());
                $userStatistic->setCountLogin($userStatistic->getCountLogin() + 1);

                $this->container->get('fitbase_entity_manager')->persist($userStatistic);
                $this->container->get('fitbase_entity_manager')->flush($userStatistic);
            }
        }
    }

    /**
     * Store statistic to database
     * @param UserStatisticVideoEvent $event
     */
    public function onStatisticUserVideoEvent(UserStatisticVideoEvent $event)
    {
        assert(($statistic = $event->getEntity()), 'Statistic object can not be empty');

        $isStatisticExists = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticVideo')
            ->getStatisticExists($statistic);

        if (!$isStatisticExists) {

            $this->container->get('fitbase_entity_manager')->persist($statistic);
            $this->container->get('fitbase_entity_manager')->flush($statistic);
        }

        $userManager = $this->container->get('fitbase_manager.user');

        if (($user = $userManager->find($statistic->getUserId()))) {

            $userStatisticRepository = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic');

            if (($userStatistic = $userStatisticRepository->findOneBy(array('user' => $user)))) {

                $videoCountProcessed = $this->container->get('fitbase_entity_manager')
                    ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticVideo')
                    ->getUserViewCountTotal($user->getId());

                $userStatistic->setCountVideo($videoCountProcessed);

                $this->container->get('fitbase_entity_manager')->persist($userStatistic);
                $this->container->get('fitbase_entity_manager')->flush($userStatistic);
            }
        }
    }
}