<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklyquizSenderCommand extends SafeCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklyquiz:sender')
            ->setDescription('Weekly quiz sender command, send queue from planning table');
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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
     */
    protected function doExecuteSafe(InputInterface $input, OutputInterface $output)
    {
        $serviceUser = $this->get('user');
        $datetime = $this->get('datetime')->getDateTime('now');

        if (($collection = $this->get('weeklyquiz')->toSend($datetime))) {
            foreach ($collection as $weeklyquizUser) {

                if (($user = $weeklyquizUser->getUser()) and
                    $serviceUser->isGranted($user, $this->getRoles())
                ) {

                    $this->doProcessEntity($weeklyquizUser);
                }
            }
        }
    }


    /**
     * Process current element
     *
     * @param WeeklyquizUser $weeklytaskUser
     */
    protected function doProcessEntity(WeeklyquizUser $weeklytaskUser)
    {
        try {

            $this->get('event_dispatcher')->dispatch('fitbase.weeklyquiz_reminder_process',
                new WeeklyquizUserEvent($weeklytaskUser));

        } catch (\Exception $ex) {

            $weeklytaskUser->setErrorMessage($ex->getMessage());
            $this->get('event_dispatcher')->dispatch('fitbase.weeklyquiz_reminder_exception',
                new WeeklyquizUserEvent($weeklytaskUser));

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