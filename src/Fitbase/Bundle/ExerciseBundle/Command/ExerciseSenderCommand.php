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

        $date = $datetime->getDateTime('now');
        $repository = $entityManager->getrepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder');
        if (($collection = $repository->findNotProcessed($date))) {
            foreach ($collection as $exerciseUserReminder) {
                $user = $exerciseUserReminder->getUser();
                if ($serviceUser->isGranted($user, $this->getRoles())) {
                    $this->doProcessEntity($exerciseUserReminder);
                }
            }
        }
    }

    /**
     * Process current entity
     * @param $exerciseUserReminder
     */
    protected function doProcessEntity($exerciseUserReminder)
    {
        try {

            $this->get('logger')->debug('Send exercise reminder', [
                $exerciseUserReminder->getUser()->getId(),
                $exerciseUserReminder->getDate()
            ]);

            $this->get('event_dispatcher')->dispatch('fitbase.exercise_reminder_process',
                new ExerciseUserReminderEvent($exerciseUserReminder));

        } catch (\Exception $ex) {

            $exerciseUserReminder->setErrorMessage($ex->getMessage());
            $this->get('event_dispatcher')->dispatch('fitbase.exercise_reminder_exception',
                new ExerciseUserReminderEvent($exerciseUserReminder));

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