<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklytaskForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklytaskSearchForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeeklytaskUserController extends Controller
{
    /**
     * Display user statistic
     * @return string
     */
    public function listDoneAction()
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

            $tasks = $taskRepository->findAllByUserAndDone($user);

            return $this->render('FitbaseWeeklytaskBundle:WeeklytaskUser:listDone.html.twig', array(
                'tasks' => $tasks
            ));
        }
    }

    /**
     * Display current Task
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function listToDoneAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

            $tasks = $taskRepository->findAllByUserAndNotDone($user);

            return $this->render('FitbaseWeeklytaskBundle:WeeklytaskUser:listToDone.html.twig', array(
                'tasks' => $tasks
            ));
        }
    }

    /**
     * Display count of finished tasks
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function countDoneAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

            return $this->render('FitbaseWeeklytaskBundle:WeeklytaskUser:count.html.twig', array(
                'count' => $taskRepository->findCountByUserAndDone($user)
            ));
        }
    }

    /**
     * Display processed task points
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function countPointAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $taskRepository = $this->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

            return $this->render('FitbaseWeeklytaskBundle:WeeklytaskUser:count.html.twig', array(
                'count' => $taskRepository->findSumPointByUserAndDone($user)
            ));
        }
    }

    /**
     * Display current task status
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            if (($post = $this->get('fitbase_service.wordpress')->getCurrentPost())) {

                $repositoryWeeklytaskUser = $this->get('fitbase_entity_manager')
                    ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

                if (($weeklytaskUser = $repositoryWeeklytaskUser->findOneByUserAndPost($user, $post))) {
                    if (!$weeklytaskUser->getDone()) {
                        $weeklytaskUserEvent = new WeeklytaskUserEvent($weeklytaskUser);
                        $this->get('event_dispatcher')->dispatch('weeklytask_user_done', $weeklytaskUserEvent);
                    }
                }
            }
        }

        return new Response('', 200);
    }
}
