<?php
namespace Fitbase\Bundle\ReminderBundle\Command;

use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReminderUserPauseDisableCommand extends SafeCommand
{
    protected function configure()
    {
        $this->setName('fitbase:pause:disable')
            ->setDescription('Disable fitbase pause for user by timeout');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function doExecuteSafe(InputInterface $input, OutputInterface $output)
    {
        $managerEntity = $this->getContainer()->get('entity_manager');
        $repositoryReminderUser = $managerEntity->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        if (($datetime = $this->getContainer()->get('datetime')->getDateTime('now'))) {
            if (($reminders = $repositoryReminderUser->findPausedByDate($datetime))) {
                foreach ($reminders as $reminder) {

                    $datetime->modify("+{$reminder->getPause()} week");

                    if ($reminder->getPauseStart() <= $datetime) {

                        $event = new ReminderUserEvent($reminder);
                        $this->getContainer()->get('event_dispatcher')
                            ->dispatch('fitbase.reminder_user_pause_disable', $event);
                    }
                }
            }
        }
    }
}