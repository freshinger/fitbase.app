<?php

namespace Fitbase\Bundle\ReminderBundle\Controller;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan;
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
        $plan = $this->get('fitbase_entity_manager')
            ->find('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan', $id);

        if ($plan instanceof ReminderUserPlan) {

            $event = new ReminderUserPlanEvent($plan);
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

        $plans = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan')
            ->findReminderPlanListCurrent();


        $repositoryReminderUserPlan = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan');

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
