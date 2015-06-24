<?php
namespace Fitbase\Bundle\UserBundle\Command;

use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserRemoveCommand extends SafeCommand
{
    /**
     * Configure current console task
     */
    protected function configure()
    {
        $this->setName('fitbase:users:remove-requested')
            ->setDescription('Remove all users with activated remove request');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function doExecuteSafe(InputInterface $input, OutputInterface $output)
    {
        if (($collection = $this->getContainer()->get('user')->getUsersToRemove())) {
            foreach ($collection as $user) {

                $this->getContainer()->get('event_dispatcher')->dispatch(
                    'fitbase.user_remove', new UserEvent($user));
            }
        }
    }
}