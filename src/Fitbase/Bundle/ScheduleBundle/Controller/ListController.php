<?php

namespace Fitbase\Bundle\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ListController
 *
 * @author  Julien Guyon <julienguyon@hotmail.com>
 * @package JMose\CommandSchedulerBundle\Controller
 */
class ListController extends \JMose\CommandSchedulerBundle\Controller\ListController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $scheduledCommands = $this->getDoctrine()->getRepository('JMoseCommandSchedulerBundle:ScheduledCommand')->findAll();

        return $this->render('FitbaseScheduleBundle:List:index.html.twig', array(
                'scheduledCommands' => $scheduledCommands,
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
                'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            )
        );
    }
}
