<?php
namespace Fitbase\Bundle\ReminderBundle\Command;

use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ReminderCreateEmptyCommand extends ContainerAwareCommand
{
    /**
     * Configure current task
     *
     */
    protected function configure()
    {
        $this->setName('fitbase:reminder:create-empty')
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

        $managerUser = $this->getContainer()->get('user');
        $repositoryReminder = $this->getContainer()->get('entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        $logger->info('Pause expire task, start');

        foreach ($managerUser->findAll() as $user) {


            if (!($reminder = $repositoryReminder->findOneByUser($user))) {

                $event = new UserEvent($user);
                $this->getContainer()->get('event_dispatcher')
                    ->dispatch('reminder_notxists', $event);

            }

        }

        $logger->info('Pause expire task, end ');
    }
}
