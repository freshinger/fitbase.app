<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ExerciseBundle\Command;


use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ExerciseSenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:exercise:sender')
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
        $entityManager = $this->get('entity_manager');
        $repository = $entityManager->getrepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder');

        $date = $datetime->getDateTime('now');
        if (($collection = $repository->findNotProcessed($date))) {
            foreach ($collection as $exerciseUserReminder) {

                $user = $exerciseUserReminder->getUser();
                if ($serviceUser->isGranted($user, $this->getRoles())) {

                    try {

                        $exerciseUserReminder->setProcessed(true);
                        $exerciseUserReminder->setProcessedDate($date);
                        $this->doProcessExerciseUserReminder($user, $exerciseUserReminder);

                    } catch (\Exception $ex) {

                        $exerciseUserReminder->setError(true);
                        $exerciseUserReminder->setErrorMessage($ex->getMessage());
                        $this->doExceptionExerciseUserReminder($user, $exerciseUserReminder);

                        $this->get('logger')->err($ex->getMessage());

                        continue;
                    }
                }
            }
        }
    }

    /**
     * Process exercise user reminder
     * @param $user
     * @param $exerciseUserReminder
     */
    protected function doProcessExerciseUserReminder($user, $exerciseUserReminder)
    {
        $this->get('event_dispatcher')
            ->dispatch('fitbase.exercise_reminder_process',
                new ExerciseUserReminderEvent($exerciseUserReminder));
    }

    /**
     * Remove reminders with errors from list,
     * store information about error for admin and dev-team
     *
     * @param $user
     * @param $exerciseUserReminder
     */
    protected function doExceptionExerciseUserReminder($user, $exerciseUserReminder)
    {
        $this->get('event_dispatcher')
            ->dispatch('fitbase.exercise_reminder_exception',
                new ExerciseUserReminderEvent($exerciseUserReminder));
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