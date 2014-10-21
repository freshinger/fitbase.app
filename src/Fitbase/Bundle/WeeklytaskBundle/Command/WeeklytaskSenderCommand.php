<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklytaskSenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:sender')
            ->setDescription('Weekly task sender command, send queue from planning table');
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
        $logger->info('Weekly task, start sender');

        $managerUser = $this->getContainer()->get('fitbase_manager.user');
        $repositoryReminder = $this->getContainer()->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        if (($collection = $repositoryReminder->findAllByNotPauseAndSendWeeklytask())) {
            foreach ($collection as $key => $reminder) {

                if (($user = $managerUser->find($reminder->getUserId()))) {

                    $logger->info('Weekly task, sender for user', array($user->getId()));

                    $this->getContainer()->get('event_dispatcher')
                        ->dispatch('weeklytask_user_send', new UserEvent($user));
                }
            }
        }

        $logger->info('Weekly task, end sender');
    }

}