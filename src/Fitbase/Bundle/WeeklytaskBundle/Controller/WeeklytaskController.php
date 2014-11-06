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
    public function viewAction(Request $request, $unique = null)
    {
        $weeklytask = null;

        $entityManager = $this->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        if (($weeklytask = $repositoryWeeklytask->find($unique))) {
            $event = new WeeklytaskEvent($weeklytask);
            $this->get('event_dispatcher')->dispatch('weeklytask_user_view', $event);
            $this->get('logger')->debug('[fitbase] weeklytask view', array($weeklytask->getId()));
        }

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:view.html.twig', array(
            'weeklytask' => $weeklytask,
        ));
    }
}