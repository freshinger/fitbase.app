<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Command;


use Fitbase\Bundle\ReminderBundle\Event\ReminderUserPlanEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ReminderSenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:reminder:sender')
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

        $logger = $this->getContainer()->get('logger');

        $dateTime = $this->getContainer()->get('datetime');

        $repositoryReminder = $this->getContainer()->get('entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');
        $repositoryReminderPlan = $this->getContainer()->get('entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan');

        $logger->info('Reminder sender, start');

        if (($collection = $repositoryReminder->findAllByNotPause())) {

            $dateMax = $dateTime->getDateTime('now');

            foreach ($collection as $reminder) {
                $logger->info('Reminder sender, date: ', array($dateMax->format('Y-m-d H:i:s')));
                if (($collectionPlan = $repositoryReminderPlan->findAllByReminderAndDayAndNotProcessed($reminder, $dateMax))) {

                    foreach ($collectionPlan as $reminderPlan) {

                        $logger->info('Reminder sender, plan found: ', array($reminderPlan->getDate()->format('Y-m-d H:i:s')));

                        $event = new ReminderUserPlanEvent($reminderPlan);
                        $this->getContainer()->get('event_dispatcher')
                            ->dispatch('reminder_sender', $event);
                    }
                }
            }
        }

        $logger->info('Reminder sender, end');
    }
} 