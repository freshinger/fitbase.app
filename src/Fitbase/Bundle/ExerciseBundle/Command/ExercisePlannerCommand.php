<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ExerciseBundle\Command;


use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ExercisePlannerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:exercise:planner')
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
        $datetime = $this->get('datetime')->getDateTime('now');

        $day = $datetime->format('N');
        $serviceUser = $this->get('user');
        if (($collection = $this->get('reminder')->getItemsExercise($day))) {
            foreach ($collection as $reminderUserItem) {
                if ($serviceUser->isGranted($reminderUserItem->getUser(), 'ROLE_USER')) {
                    $event = new ExerciseReminderEvent($reminderUserItem);
                    $this->get('event_dispatcher')->dispatch('exercise_reminder_create', $event);
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