<?php

namespace Fitbase\Bundle\ReminderBundle\Controller;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan;
use Fitbase\Bundle\ReminderBundle\Event\ReminderPlanEvent;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserPlanEvent;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReminderPlanController extends Controller
{
    /**
     * Send current selected plan
     * @param $id
     */
    public function sendAction($id)
    {
        $plan = $this->get('entity_manager')
            ->find('Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan', $id);

        if ($plan instanceof ReminderPlan) {

            $event = new ReminderPlanEvent($plan);
            $this->get('event_dispatcher')->dispatch('reminder_sender', $event);

            $this->get('session')->getFlashBag()->add('notice', 'Ein Reminder wurde erfolgreich versendet');
        }
    }

    /**
     * Display current reminder plan
     */
    public function listAction(Request $request)
    {
        if (($id = $this->get('request')->get('reminder_plan_id'))) {
            $this->sendAction($id);
        }

        $plans = $this->get('entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan')
            ->findReminderPlanListCurrent();


        $repositoryReminderUserPlan = $this->get('entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderPlan');

        $pagerfantaProcessed = new Pagerfanta(new DoctrineORMAdapter(
            $repositoryReminderUserPlan->findAllProcessedQueryBuilder()
        ));

        $pagerfantaProcessed->setMaxPerPage(50);
        $pagerfantaProcessed->setCurrentPage($request->get('navigate', 1));

        return $this->render('FitbaseReminderBundle:ReminderPlan:list.html.twig', array(
            'plans' => $plans,
            'pagerfantaProcessed' => $pagerfantaProcessed,
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }
}
