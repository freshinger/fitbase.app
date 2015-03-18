<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;


class WeeklytaskPlannerCommand extends ContainerAwareCommand
{
    /**
     * Configure current console task
     */
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:planner')
            ->setDescription('Create Weeklyquiz-User association');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serviceUser = $this->get('user');
        $datetime = $this->get('datetime')->getDateTime('now');

        $day = $datetime->format('N');
        if (($collection = $this->get('reminder')->getItemsWeeklytask($day))) {
            $backend = $this->get('sonata.notification.backend');
            foreach ($collection as $reminderUserItem) {

                if (($user = $reminderUserItem->getUser())) {
                    if ($serviceUser->isGranted($user, 'ROLE_USER')) {
                        $output->writeln("Infoeinheit reminder for user: {$user->getId()} found");
                        $backend->createAndPublish('weeklytask_planner', array(
                            'user' => $user,
                            'item' => $reminderUserItem,
                        ));
                    }

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