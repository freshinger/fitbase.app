<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklytaskSenderCommand extends SafeCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:sender')
            ->setDescription('Weekly task sender command, send queue from planning table');
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
        $datetime = $this->get('datetime')->getDateTime('now');

        if (($collection = $this->get('weeklytask')->toSend($datetime))) { // TODO: do a refactoring for this method
            foreach ($collection as $weeklytaskUser) {

                if (($user = $weeklytaskUser->getUser()) and
                    $serviceUser->isGranted($user, $this->getRoles())) {

                    $this->doProcessEntity($weeklytaskUser);
                }
            }
        }
    }

    /**
     * Process current entity
     *
     * @param WeeklytaskUser $weeklytaskUser
     */
    protected function doProcessEntity(WeeklytaskUser $weeklytaskUser)
    {
        try {

            $this->get('event_dispatcher')->dispatch('fitbase.weeklytask_reminder_process',
                new WeeklytaskUserEvent($weeklytaskUser));

        } catch (\Exception $ex) {

            $weeklytaskUser->setErrorMessage($ex->getMessage());
            $this->get('event_dispatcher')->dispatch('fitbase.weeklytask_reminder_exception',
                new WeeklytaskUserEvent($weeklytaskUser));

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