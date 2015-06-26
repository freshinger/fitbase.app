<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeLockCommand;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Exception\WeeklytaskLastException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class WeeklytaskPlannerCommand extends SafeCommand
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
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function doExecuteSafe(InputInterface $input, OutputInterface $output)
    {
        $serviceUser = $this->get('user');
        $datetime = $this->get('datetime');

        $day = $datetime->format('N');

        if (($collection = $this->get('reminder')->getItemsWeeklytask($day))) {
            foreach ($collection as $reminderUserItem) {
                if ((($user = $reminderUserItem->getUser())) and
                    $serviceUser->isGranted($user, $this->getRoles())
                ) {

                    $hour = $reminderUserItem->getTime()->format('H');
                    $minute = $reminderUserItem->getTime()->format('i');

                    $date = $datetime->getDateTime('now');
                    $date->setTime($hour, $minute);

                    $this->doProcessEntity(
                        (new WeeklytaskUser())
                            ->setUser($user)
                            ->setDate($date)
                            ->setProcessed(0)
                            ->setProcessedDate(null)
                    );
                }
            }
        }
    }

    /**
     * Process current entity
     *
     * @param $weeklytaskUser
     */
    protected function doProcessEntity(WeeklytaskUser $weeklytaskUser)
    {
        try {

            $this->get('event_dispatcher')->dispatch('fitbase.weeklytask_reminder_create',
                new WeeklytaskUserEvent($weeklytaskUser));

        } catch (WeeklytaskLastException $ex) {

            $this->get('event_dispatcher')->dispatch('fitbase.weeklytask_reminder_last',
                new WeeklytaskUserEvent($weeklytaskUser));

            $this->get('logger')->err($ex->getMessage(), [
                $weeklytaskUser->getUser()->getId(),
                $weeklytaskUser->getDate()
            ]);

        } catch (\Exception $ex) {

            $this->get('logger')->err($ex->getMessage(), [
                $weeklytaskUser->getUser()->getId(),
                $weeklytaskUser->getDate()
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