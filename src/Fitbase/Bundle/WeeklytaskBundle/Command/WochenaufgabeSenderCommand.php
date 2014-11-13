<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WochenaufgabeSenderCommand extends ContainerAwareCommand
{
    /**
     * Configure current console task
     *
     */
    protected function configure()
    {
        $this->setName('fitbase:wochenaufgaben:sender')
            ->setDescription('Send weekly tasks to users');
    }

    /**
     * Delivery current queue
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        $dateTime = $this->getContainer()->get('datetime');
        $managerUser = $this->getContainer()->get('user');
        $repositoryWeeklyTask = $this->getContainer()->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyTasks');


        $logger->info('Wochenaufgaben, start sender');

        if (($tasks = $repositoryWeeklyTask->findTaskListToSend($dateTime))) {

            foreach ($tasks as $task) {

                if (($user = $managerUser->find($task->getUserId()))) {

                    if (($this->getContainer()->get('fitbase_service.reminder')->getIsPause($user))) {
                        $logger->info('Wochenaufgaben, pause', array(
                            $user->getId(),
                        ));
                        continue;
                    }

                    $event = new WeeklyTaskEvent($task);
                    $this->getContainer()->get('event_dispatcher')
                        ->dispatch('wochenaufgabe_send', $event);
                }
            }
        }

        $logger->info('Wochenaufgaben, end sender');
    }

}