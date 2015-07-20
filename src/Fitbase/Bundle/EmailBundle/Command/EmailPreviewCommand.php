<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\EmailBundle\Command;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class EmailPreviewCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:email:preview')
            ->setDescription('Render user emails to console')
            ->addArgument('unique', null, 'User reminder id');
    }

    /**
     * Execute task
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('entity_manager');
        $repository = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder');

        if (!($reminders = $repository->findByIdArray(explode(',', $input->getArgument('unique'))))) {
            $output->writeln('ExerciseUserReminder object not found');
            return;
        }

        foreach ($reminders as $reminder) {

            if (!($user = $reminder->getUser())) {
                throw new \LogicException('ExerciseUserReminder object not found');
            }

            $output->writeln($this->getContainer()->get('fitbase.email_builder')
                ->getExerciseUserReminderEmail($user, $user->getCompany(),
                    $user->getFocus()->getFirstCategory()->getCategory(), $user->getFocus()->getFirstCategories()));
        }
    }
}