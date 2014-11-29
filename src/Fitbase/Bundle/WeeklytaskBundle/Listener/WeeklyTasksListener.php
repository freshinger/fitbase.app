<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WeeklyTasksListener extends ContainerAware
{
    /**
     * Mark current task as sent
     * @param WeeklyTaskEvent $event
     */
    public function onWochenaufgabeSent(WeeklyTaskEvent $event)
    {
        assert(is_object(($task = $event->getEntity())));

        $this->container->get('logger')
            ->info('Wochenaufgaben, processed', array(
                (string)$task
            ));

        $task->setProcessed(true);
        $task->setProcessedDate($this->container->get('datetime')->getDateTime('now'));

        $this->container->get('entity_manager')->persist($task);
        $this->container->get('entity_manager')->flush($task);
    }


    /**
     * Create task planning for one user
     * check user start date and current date,
     * ich no task exists in table, then create new task
     * @param UserEvent $event
     * @return bool
     */
    public function onWeeklyTaskPlanning($event)
    {
        assert(is_object(($user = $event->getEntity())));
        $logger = $this->container->get('logger');
        $entityManager = $this->container->get('entity_manager');
        $postMetaRepository = $entityManager->getRepository('Ekino\WordpressBundle\Entity\PostMeta');
        $weeklyTaskRepository = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

        $logger->info('Wochenaufgaben, plan user', array(
            $user->getId()
        ));

        // Default week is 1
        $weekId = 1;
        // Try to find last processed task and
        // increment week number from this task
        if (($task = $weeklyTaskRepository->findLastProcessedByUser($user))) {
            $weekId = $task->getWeekId() + 1;
        }

        // Find post with this week number
        // to set as a weekly task
        if (!($postMeta = $postMetaRepository->findOneBy(array('key' => 'week', 'value' => $weekId,)))) {
            $logger->info('Wochenaufgaben, empty post-meta');
            return;
        }

        assert(is_object(($post = $postMeta->getPost())));

        $logger->info('Wochenaufgaben, task found', array(
            $post->getId(),
        ));

        // Check here is a task has been already planed
        // break up this logic if so
        if (($task = $weeklyTaskRepository->findOneByUserAndPost($user, $post))) {
            $logger->info('Wochenaufgaben, task exists', array(
                $task->getId()
            ));
            return;
        }

        $dateTime = $this->container->get('weeklytask');

        $next = $dateTime->getUserNextDate($user);
        // Set time to 4 o'clock am
        $next->setTime(4, 0, 0);

        $task = new WeeklyTasks();
        $task->setDate($next);
        $task->setWeekId($weekId);
        $task->setUserId($user->getId());
        $task->setTaskId($post->getId());
        $task->setProcessed(false);

        $this->container->get('entity_manager')->persist($task);
        $this->container->get('entity_manager')->flush($task);

        $logger->info('Wochenaufgaben, task created', array(
            $task->getId()
        ));
    }

    /**
     * Process weekly tag by use
     * @param WeeklyTaskEvent $event
     * @return bool
     */
    public function onWochenaufgabeDone(WeeklyTaskEvent $event)
    {
        $this->container->get('logger')->info('Weekly process task', array((string)$event));

        assert(is_object(($task = $event->getEntity())));

        $task->setDone(true);
        $task->setDoneDate($this->container->get('datetime')->getDateTime('now'));

        $this->container->get('entity_manager')->persist($task);
        $this->container->get('entity_manager')->flush($task);

        $this->container->get('logger')->info('Weekly process task, done', array((string)$task));
    }

}