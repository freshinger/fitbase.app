<?php

namespace Fitbase\Bundle\ScheduleBundle\Controller;

use Fitbase\Bundle\ScheduleBundle\Form\ScheduledCommandForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use JMose\CommandSchedulerBundle\Entity\ScheduledCommand;
use JMose\CommandSchedulerBundle\Form\Type\ScheduledCommandType;

/**
 * Class DetailController
 *
 * @author  Julien Guyon <julienguyon@hotmail.com>
 * @package JMose\CommandSchedulerBundle\Controller
 */
class DetailController extends \JMose\CommandSchedulerBundle\Controller\DetailController
{

    /**
     * Handle display of new/existing ScheduledCommand object.
     * This action should not be invoke directly
     *
     * @param ScheduledCommand $scheduledCommand
     * @param Form $scheduledCommandForm
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(ScheduledCommand $scheduledCommand, Form $scheduledCommandForm = null)
    {
        if (null === $scheduledCommandForm) {

            $scheduledCommandForm = $this->createForm(new ScheduledCommandForm($this->get('jmose_command_scheduler.command_choice_list')), $scheduledCommand);
        }

        return $this->render('FitbaseScheduleBundle:Detail:index.html.twig', array(
                'scheduledCommandForm' => $scheduledCommandForm->createView(),
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
                'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            )
        );
    }

    /**
     * Initialize a new ScheduledCommand object and forward to the index action (view)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function initNewScheduledCommandAction()
    {
        $scheduledCommand = new ScheduledCommand();

        return $this->forward(
            'FitbaseScheduleBundle:Detail:index', array(
                'scheduledCommand' => $scheduledCommand,
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
                'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            )
        );
    }

    /**
     * Get a ScheduledCommand object with its id and forward it to the index action (view)
     *
     * @param $scheduledCommandId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function initEditScheduledCommandAction($scheduledCommandId)
    {
        $scheduledCommand = $this->getDoctrine()->getRepository('JMoseCommandSchedulerBundle:ScheduledCommand')
            ->find($scheduledCommandId);

        return $this->forward(
            'FitbaseScheduleBundle:Detail:index', array(
                'scheduledCommand' => $scheduledCommand,
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
                'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            )
        );
    }

    /**
     * Handle save after form is submit and forward to the index action (view)
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Init and populate form object
        if ($request->request->get('command_scheduler_detail')['id'] != '') {
            $scheduledCommand = $entityManager->getRepository('JMoseCommandSchedulerBundle:ScheduledCommand')
                ->find($request->request->get('command_scheduler_detail')['id']);
        } else {
            $scheduledCommand = new ScheduledCommand();
        }

        $scheduledCommandForm = $this->createForm(new ScheduledCommandForm($this->get('jmose_command_scheduler.command_choice_list')), $scheduledCommand);
        $scheduledCommandForm->handleRequest($request);

        if ($scheduledCommandForm->isValid()) {

            // Handle save to the database
            if (null === $scheduledCommand->getId()) {
                $scheduledCommand->setLastExecution(new \DateTime());
                $scheduledCommand->setLocked(false);
                $entityManager->persist($scheduledCommand);
            }
            $entityManager->flush();

            // Add a flash message and do a redirect to the list
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('commandeScheduler.flash.success'));

            return $this->redirect($this->generateUrl('jmose_command_scheduler_list'));

        } else {
            return $this->forward(
                'FitbaseScheduleBundle:Detail:index', array(
                    'scheduledCommand' => $scheduledCommand,
                    'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                    'admin_pool' => $this->container->get('sonata.admin.pool'),
                    'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
                )
            );
        }
    }
}
