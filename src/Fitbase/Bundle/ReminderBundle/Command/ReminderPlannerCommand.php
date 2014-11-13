<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Command;


use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ReminderPlannerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:reminder:planner')
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
        $logger = $this->getContainer()->get('logger');

        $repositoryReminder = $this->getContainer()->get('entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        $logger->info('Reminder planner task, start');

        if (($collection = $repositoryReminder->findAllByNotPause())) {
            foreach ($collection as $reminder) {

                $event = new ReminderUserEvent($reminder);
                $this->getContainer()->get('event_dispatcher')
                    ->dispatch('reminder_planner', $event);
            }
        }

        $logger->info('Reminder planner task, end ');
    }
} 