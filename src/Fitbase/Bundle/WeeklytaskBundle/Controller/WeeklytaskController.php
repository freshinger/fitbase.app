<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskPlanEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizEvent;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklytaskForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizForm;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklytaskSearchForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeeklytaskController extends Controller
{
    /**
     * Display current task status
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function weeklytaskAction(Request $request)
    {
        $countWeeklytaskDone = 0;
        $countWeeklytaskPointDone = 0;
        $collectionWeeklytaskActual = array();
        $collectionWeeklytaskArchive = array();

        if (($user = $this->get('user')->current())) {
            $weeklytaskRepository = $this->get('entity_manager')->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

            $countWeeklytaskDone = $weeklytaskRepository->findCountByUserAndDone($user);
            $countWeeklytaskPointDone = $weeklytaskRepository->findSumPointByUserAndDone($user);

            $collectionWeeklytaskActual = $weeklytaskRepository->findAllByUserAndNotDone($user);
            $collectionWeeklytaskArchive = $weeklytaskRepository->findAllByUserAndDone($user);
        }

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:list.html.twig', array(
            'countWeeklytaskDone' => $countWeeklytaskDone,
            'countWeeklytaskPointDone' => $countWeeklytaskPointDone,
            'collectionWeeklytaskActual' => $collectionWeeklytaskActual,
            'collectionWeeklytaskArchive' => $collectionWeeklytaskArchive,
        ));
    }

    /**
     * Display current task status
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function weeklytaskShowAction($unique, Request $request)
    {
        $weeklytask = null;
        if (($user = $this->get('user')->current())) {

            $repositoryWeeklytask = $this->get('entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

            if (($weeklytask = $repositoryWeeklytask->find($unique))) {
//                if (($weeklytaskUser = $repositoryWeeklytaskUser->findOneByUserAndPost($user, $post))) {
//                    if (!$weeklytaskUser->getDone()) {
//                        $weeklytaskUserEvent = new WeeklytaskUserEvent($weeklytaskUser);
//                        $this->get('event_dispatcher')->dispatch('weeklytask_user_done', $weeklytaskUserEvent);
//                    }
//                }

                }
        }


        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:show.html.twig', array(
            'weeklytask' => $weeklytask,
        ));
    }
}