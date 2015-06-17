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
        $datetime = $this->get('datetime');
        $serviceUser = $this->get('user');

        $day = $datetime->getDateTime('now')->format('N');
        if (($collection = $this->get('reminder')->getItemsExercise($day))) {
            foreach ($collection as $reminderUserItem) {

                if (($user = $reminderUserItem->getUser()) and
                    $serviceUser->isGranted($user, $this->getRoles())) {

                    $date = $datetime->getDateTime('now');
                    $date->setTime($reminderUserItem->getTime()->format('H'),
                        $reminderUserItem->getTime()->format('i'));

                    $this->doProcessEntity(
                        (new ExerciseUserReminder())
                            ->setUser($user)
                            ->setDate($date)
                    );

                }
            }
        }
    }

    /**
     * Process current entity
     *
     * @param $exerciseUserReminder
     */
    protected function doProcessEntity($exerciseUserReminder)
    {
        try {

            $this->get('event_dispatcher')->dispatch('fitbase.exercise_reminder_create',
                new ExerciseUserReminderEvent($exerciseUserReminder));

        } catch (\Exception $ex) {
            $this->get('logger')->err($ex->getMessage(), [
                $exerciseUserReminder->getUser()->getId(),
                $exerciseUserReminder->getDate()
            ]);
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