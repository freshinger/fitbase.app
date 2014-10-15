<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WochenaufgabePlannerCommand extends ContainerAwareCommand
{
    /**
     * Configure current task
     *
     */
    protected function configure()
    {
        $this->setName('fitbase:wochenaufgaben:planner')
            ->setDescription('Plan weekly tasks for user');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');

        $logger->info('Wochenaufgaben, start planner');

        $repositoryReminder = $this->getContainer()->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\UserReminder');

        if (($collection = $repositoryReminder->findAllByNotPause())) {
            foreach ($collection as $reminder) {
                if (($user = $this->getContainer()->get('fitbase_manager.user')->find($reminder->getUserId()))) {

                    $event = new UserEvent($user);
                    $this->getContainer()->get('event_dispatcher')
                        ->dispatch('wochenaufgabe_planning', $event);
                }
            }
        }

        $logger->info('Wochenaufgaben, end planner');
    }

}