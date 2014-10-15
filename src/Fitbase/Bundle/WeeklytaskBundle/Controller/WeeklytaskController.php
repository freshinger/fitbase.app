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

class WeeklytaskController extends Controller
{
    public function weeklytaskAction(Request $request)
    {
        if (($unique = $request->get('weeklytask_create'))) {
            return $this->weeklytaskCreateAction($request);
        }

        if (($unique = $request->get('weeklytask_id_edit'))) {
            return $this->weeklytaskUpdateAction($request, $unique);
        }

        if (($unique = $request->get('weeklytask_id_remove'))) {
            $this->weeklytaskRemoveAction($request, $unique);
        }

        $weeklytaskSearch = new WeeklytaskSearch();
        $weeklytaskSearch->setOrder('weekId');
        $weeklytaskSearch->setBy('asc');

        $formSearch = $this->createForm(new WeeklytaskSearchForm(), $weeklytaskSearch);
        if ($request->get($formSearch->getName())) {
            $formSearch->handleRequest($request);
        }

        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');


        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter(
            $repositoryWeeklytask->findAllQueryBuilder($weeklytaskSearch)
        ));

        $pagerfanta->setMaxPerPage(50);
        $pagerfanta->setCurrentPage($request->get('navigate', 1));


        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:weeklytask.html.twig', array(
            'formSearch' => $formSearch->createView(),
            'pagerfanta' => $pagerfanta,
            'categories' => $repositoryWeeklytask->findAllCategory(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }

    /**
     * Action to remove weekly task
     * @param Request $request
     * @param null $unique
     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse
     */
    public function weeklytaskRemoveAction(Request $request, $unique = null)
    {
        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        if (($weeklytask = $repositoryWeeklytask->find($unique))) {

            $event = new WeeklytaskEvent($weeklytask);
            $this->get('event_dispatcher')->dispatch('weeklytask_remove', $event);

            $this->get('session')->getFlashBag()->add('notice', 'Die Wochenaufgabe wurde erfolgreich geloescht.');

            return $this->redirect('?page=wochenaufgaben');
        }
    }

    /**
     * Create weeklytask
     * @param Request $request
     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function weeklytaskCreateAction(Request $request)
    {
        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');


        $form = $this->createForm(new WeeklytaskForm(), new Weeklytask());
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $event = new WeeklytaskEvent($form->getData());
                $this->get('event_dispatcher')->dispatch('weeklytask_update', $event);

                $this->get('session')->getFlashBag()->add('notice', 'Die Wochenaufgabedaten wurden erfolgreich geaendert.');

                return $this->redirect('?page=wochenaufgaben');
            }
        }

        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:weeklytask_update.html.twig', array(
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }


    /**
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function weeklytaskUpdateAction(Request $request, $unique = null)
    {
        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        if (($weeklytask = $repositoryWeeklytask->find($unique))) {

            $form = $this->createForm(new WeeklytaskForm(), $weeklytask);
            if ($request->get($form->getName())) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $event = new WeeklytaskEvent($form->getData());
                    $this->get('event_dispatcher')->dispatch('weeklytask_update', $event);

                    $this->get('session')->getFlashBag()->add('notice', 'Die Wochenaufgabedaten wurden erfolgreich geaendert.');

                    return $this->redirect('?page=wochenaufgaben');
                }
            }

            return $this->render('FitbaseWeeklytaskBundle:Weeklytask:weeklytask_update.html.twig', array(
                'form' => $form->createView(),
                'flashbag' => $this->get('session')->getFlashBag(),
            ));
        }
    }

    /**
     * Display weeklytask plan
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function weeklytaskPlanAction(Request $request)
    {
        if (($unique = $request->get('weeklytask_plan_send'))) {
            $this->weeklytaskPlanSendAction($request, $unique);
        }

        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan');


        $pagerfantaNotProcessed = new Pagerfanta(new DoctrineORMAdapter(
            $repositoryWeeklytask->findAllNotProcessedQueryBuilder()
        ));

        $pagerfantaNotProcessed->setMaxPerPage(50);
        $pagerfantaNotProcessed->setCurrentPage($request->get('notprocessed', 1));


        $pagerfantaProcessed = new Pagerfanta(new DoctrineORMAdapter(
            $repositoryWeeklytask->findAllProcessedQueryBuilder()
        ));

        $pagerfantaProcessed->setMaxPerPage(50);
        $pagerfantaProcessed->setCurrentPage($request->get('processed', 1));


        return $this->render('FitbaseWeeklytaskBundle:Weeklytask:weeklytask_plan.html.twig', array(
            'pagerfantaProcessed' => $pagerfantaProcessed,
            'pagerfantaNotProcessed' => $pagerfantaNotProcessed,
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }

    /**
     * Send weekly task
     * @param Request $request
     * @param $unique
     */
    public function weeklytaskPlanSendAction(Request $request, $unique)
    {
        $repositoryWeeklytask = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskPlan');

        if (($weeklytaskPlan = $repositoryWeeklytask->find($unique))) {

            $weeklytaskPlanEvent = new WeeklytaskPlanEvent($weeklytaskPlan);
            $this->container->get('event_dispatcher')
                ->dispatch('weeklytask_plan_send', $weeklytaskPlanEvent);

            $this->get('session')->getFlashBag()->add('notice', 'Eine Wochenaufgabe wurde erfolgreich versendet');
        }
    }

}
