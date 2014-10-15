<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Listener;


use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizPlanEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class EmailListener extends ContainerAware
{
    /**
     * Send weekly quiz
     * @param WeeklyquizPlanEvent $event
     */
    public function onWeeklyquizPlanSendEvent(WeeklyquizPlanEvent $event)
    {
        assert(is_object(($weeklytaskQuizPlan = $event->getEntity())));

        $logger = $this->container->get('logger');
        $managerEntity = $this->container->get('fitbase_entity_manager');

        // Check if user exists
        // if no break up and do nothing
        if (!($user = $this->container->get('fitbase_manager.user')->find($weeklytaskQuizPlan->getUserId()))) {
            $logger->info('Weekly quiz sender, user not exists', array($weeklytaskQuizPlan->getUserId()));
            return;
        }

        // Check if weekly task exists
        // if no break up and do nothing
        $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
        if (!($weeklytask = $repositoryWeeklytask->find($weeklytaskQuizPlan->getWeeklytaskId()))) {
            $logger->info('Weekly quiz sender, weeklytask not exists', array($weeklytaskQuizPlan->getWeeklytaskId()));
            return;
        }


        $repositoryWeeklyquiz = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');
        $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

        $logger->info('Weekly quiz sender, task found', array($weeklytask->getId()));

        $weeklytaskQuiz = $repositoryWeeklyquiz->find($weeklytaskQuizPlan->getQuizId());
        $weeklytaskUserQuiz = $repositoryWeeklyquizUser->findOneByUserAndQuizId($user, $weeklytaskQuizPlan->getQuizId());

        $email = $user->getEmail();
        $title = 'Ihr Online-Rückenschule.de Quiz';

        $content = $this->container->get('templating')->render('FitbaseWeeklytaskBundle:Email:quiz.html.twig', array(
            'user' => $user,
            'first_name' => $user->getMetaValue('first_name'),
            'last_name' => $user->getMetaValue('last_name'),
            'login_code' => md5(date('Yn') * $user->getId()),
            'weeklytask' => $weeklytask,
            'weeklytaskQuiz' => $weeklytaskQuiz,
            'weeklytaskUserQuiz' => $weeklytaskUserQuiz,
        ));

        $this->container->get('fitbase_mailer')->mail($email, $title, $content);

        $this->container->get('event_dispatcher')
            ->dispatch('weeklytask_quiz_plan_sent',
                new WeeklyquizPlanEvent($weeklytaskQuizPlan));

        $logger->info('Weekly quiz sender, done', array($user->getId()));
    }

    /**
     * Deliver email to user
     * @param WeeklyTaskEvent $event
     * @return bool
     */
    public function onWeeklytaskPlanSendEvent(WeeklytaskPlanEvent $event)
    {
        assert(is_object(($weeklytaskPlan = $event->getEntity())));

        $logger = $this->container->get('logger');
        $managerEntity = $this->container->get('fitbase_entity_manager');

        $repositoryWeeklytask = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
        $repositoryWeeklytaskUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

        if (($weeklytask = $repositoryWeeklytask->find($weeklytaskPlan->getWeeklytaskId()))) {
            $logger->info('Weekly task sender, task found', array($weeklytask->getId()));

            // TODO: change ekino classes to fitbase managers
            $post = $this->container->get('ekino.wordpress.manager.post')->find($weeklytaskPlan->getPostId());
            $user = $this->container->get('ekino.wordpress.manager.user')->find($weeklytaskPlan->getUserId());


            if (empty($post) or empty($user)) {
                $logger->info('Weekly task sender, user or post not found');

                $this->container->get('event_dispatcher')
                    ->dispatch('weeklytask_plan_sent',
                        new WeeklytaskPlanEvent($weeklytaskPlan));

                return false;
            }

            $logger->info('Weekly task sender, task found', array($user->getId(), $post->getId(),));

            $email = $user->getEmail();
            $title = 'Ihr Online-Rückenschule.de Wochenaufgabe';
            $content = $this->container->get('templating')->render('FitbaseWeeklytaskBundle:Email:task.html.twig', array(
                'task' => $post,
                'taskPoints' => $weeklytask->getCountPoint(),
                'taskCategory' => $weeklytask->getCategory(),
                'taskDescription' => $weeklytask->getDescription(),
                'taskCount' => $repositoryWeeklytaskUser->findCountByUser($user),
                'taskCountProcessed' => $repositoryWeeklytaskUser->findCountByUserAndDone($user),
                'taskCountPointsProcessed' => $repositoryWeeklytaskUser->findSumPointByUserAndDone($user),
                'user' => $user,
            ));

            $this->container->get('fitbase_mailer')->mail($email, $title, $content);

            $this->container->get('event_dispatcher')
                ->dispatch('weeklytask_plan_sent',
                    new WeeklytaskPlanEvent($weeklytaskPlan));

            $logger->info('Weekly task sender, done', array($user->getId(), $post->getId()));
        }
    }
}