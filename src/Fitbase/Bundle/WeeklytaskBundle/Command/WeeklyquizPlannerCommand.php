<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklyquizPlannerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklyquiz:planner')
            ->setDescription('Weekly quiz planner command, fill planning table by user data');
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
        $logger->info('Weekly quiz, start planner');

        $managerUser = $this->getContainer()->get('fitbase_manager.user');
        $repositoryReminder = $this->getContainer()->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\UserReminder');

        if (($collection = $repositoryReminder->findAllByNotPauseAndSendWeeklyquiz())) {
            foreach ($collection as $key => $reminder) {

                if (($user = $managerUser->find($reminder->getUserId()))) {

                    $logger->info('Weekly quiz, plan for user', array($user->getId()));

                    $this->getContainer()->get('event_dispatcher')
                        ->dispatch('weeklytask_user_quiz_plan', new UserEvent($user));
                }
            }
        }

        $logger->info('Weekly quiz, end planner');
    }

}