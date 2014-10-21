<?php
namespace Fitbase\Bundle\ReminderBundle\Command;

use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ReminderExpirePauseCommand extends ContainerAwareCommand
{
    /**
     * Configure current task
     *
     */
    protected function configure()
    {
        $this->setName('fitbase:reminder:expire-pause')
            ->setDescription('Check for expired user pauses');
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

        $repositoryReminder = $this->getContainer()->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        $logger->info('Pause expire task, start');

        if (($collection = $repositoryReminder->findAllByPause())) {
            foreach ($collection as $reminder) {

                $event = new ReminderUserEvent($reminder);
                $this->getContainer()->get('event_dispatcher')
                    ->dispatch('reminder_expire_pause', $event);
            }
        }

        $logger->info('Pause expire task, end ');
    }
}
