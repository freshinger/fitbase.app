<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WochenAufgabeController extends Controller
{
    /**
     * Display user statistic
     * @return string
     */
    public function statisticAction()
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

            $tasks = $taskRepository->findTaskListProcessedByUser($user);

            return $this->render('FitbaseWeeklytaskBundle:WochenAufgabe:statistic.html.twig', array(
                'tasks' => $tasks
            ));
        }
    }

    /**
     * Display current Task
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function currentAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

            $tasks = $taskRepository->findTaskListCurrentByUser($user);

            return $this->render('FitbaseWeeklytaskBundle:WochenAufgabe:current.html.twig', array(
                'tasks' => $tasks
            ));
        }
    }

    /**
     * Display count of finished tasks
     * @return string
     */
    public function finishedAction()
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

            return $this->render('FitbaseWeeklytaskBundle:WochenAufgabe:finished.html.twig', array(
                'count' => $taskRepository->getTaskCountProcessed($user)
            ));
        }
    }

    /**
     * Display processed task points
     * @return string
     */
    public function progressAction()
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

            return $this->render('FitbaseWeeklytaskBundle:WochenAufgabe:progress.html.twig', array(
                'count' => $taskRepository->getTaskPointsProcessed($user)
            ));
        }
    }

    /**
     * Display current task status
     * @return string
     */
    public function statusAction()
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            if (($post = $this->get('fitbase_service.wordpress')->getCurrentPost())) {

                if ($this->get('request')->get('processed')) {

                    $taskRepository = $this->get('fitbase_entity_manager')
                        ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

                    $task = $taskRepository->findOneBy(array(
                        'userId' => $user->getId(),
                        'taskId' => $post->getId(),
                    ));

                    if (!empty($task)) {
                        $this->get('event_dispatcher')
                            ->dispatch('wochenaufgabe_done',
                                new WeeklyTaskEvent($task));
                    }

                    return $this->redirect($this->generateUrl('fitbase_weekly_task'));
                }

                $taskRepository = $this->get('fitbase_entity_manager')
                    ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');

                $processed = $taskRepository->getTaskDoneStatus($user, $post);

                return $this->render('FitbaseWeeklytaskBundle:WochenAufgabe:status.html.twig', array(
                    'user' => $user,
                    'post' => $post,
                    'processed' => $processed,
                ));
            }
        }
    }

    /**
     * Send one weekly task
     * @param $id
     */
    public function sendAction($id)
    {
        $task = $this->get('fitbase_entity_manager')->find('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks', $id);

        $event = new WeeklyTaskEvent($task);
        $this->get('event_dispatcher')->dispatch('wochenaufgabe_send', $event);

        $this->get('session')->getFlashBag()->add('notice', 'Eine Wochenaufgabe wurde erfolgreich versendet');
    }

    /**
     * Display list of weekly task to process and processed
     * @return string
     */
    public function listAction()
    {
        if (($id = $this->get('request')->get('wochenaufgabe_task_id'))) {
            $this->sendAction($id);
        }

        $tasks = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks')
            ->findTaskListToProcess();

        $archive = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks')
            ->findTaskListArchive($this->get('datetime'));

        return $this->render('FitbaseWeeklytaskBundle:WochenAufgabe:list.html.twig', array(
            'tasks' => $tasks,
            'archive' => $archive,
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }
}
