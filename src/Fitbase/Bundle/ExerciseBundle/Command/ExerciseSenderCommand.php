<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ExerciseBundle\Command;


use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ExerciseSenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:exercise:sender')
            ->setDescription('Send weekly tasks to users');
    }

    /**
     * Execute task
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $context = $this->getContainer()->get('router')->getContext();
        $context->setHost($this->getContainer()->getParameter('fitbase.project.host'));
        $context->setScheme($this->getContainer()->getParameter('fitbase.project.scheme'));
        $context->setBaseUrl($this->getContainer()->getParameter('fitbase.project.url'));

        $serviceUser = $this->get('user');
        $datetime = $this->get('datetime')->getDateTime('now');
        if (($collection = $this->get('exercise')->send($datetime))) {
            foreach ($collection as $exerciseUser) {
                if ($serviceUser->isGranted($exerciseUser->getUser(), 'ROLE_FITBASE_USER')) {
                    $event = new ExerciseUserEvent($exerciseUser);
                    $this->get('event_dispatcher')->dispatch('exercise_reminder_send', $event);
                }
            }
        }
    }

    /**
     * Get service from container
     * @param $name
     * @return object
     */
    protected function get($name)
    {
        return $this->getContainer()->get($name);
    }
}