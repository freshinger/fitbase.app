<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ExerciseBundle\Command;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
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
     * Get allowed roles for current task
     * @return array
     */
    protected function getRoles()
    {
        return [
            'ROLE_FITBASE_USER',
        ];
    }


    /**
     * Execute task
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serviceUser = $this->get('user');
        $datetime = $this->get('datetime')->getDateTime('now');

        $day = $datetime->format('N');

        if (($collection = $this->get('reminder')->getItemsExercise($day))) {
            foreach ($collection as $reminderUserItem) {

                $user = $reminderUserItem->getUser();
                if ($serviceUser->isGranted($user, $this->getRoles())) {

                    $this->doCreateExerciseUserReminder($user, $reminderUserItem);
                }
            }
        }
    }

    /**
     * Create exercise reminder
     * @param $reminderUserItem
     */
    protected function doCreateExerciseUserReminder(User $user, ReminderUserItem $reminderUserItem)
    {
        $date = $this->get('datetime')->getDateTime('now');

        $date->setTime(
            $reminderUserItem->getTime()->format('H'),
            $reminderUserItem->getTime()->format('i')
        );

        $this->get('event_dispatcher')
            ->dispatch('fitbase.exercise_reminder_create',
                new ExerciseUserReminderEvent(
                    (new ExerciseUserReminder())
                        ->setUser($user)
                        ->setDate($date)
                        ->setProcessed(null)
                        ->setProcessedDate(null)
                ));
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