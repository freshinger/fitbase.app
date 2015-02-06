<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklytaskSenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:sender')
            ->setDescription('Weekly task sender command, send queue from planning table');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        exit($this->getContainer()->getParameter('fitbase'));

        // TODO: change to global config
        $context = $this->getContainer()->get('router')->getContext();
        $context->setHost('app.fitbase.de');
        $context->setScheme('https');
        $context->setBaseUrl('/default');

        $datetime = $this->get('datetime')->getDateTime('now');
        if (($collection = $this->get('weeklytask')->toSend($datetime))) {
            foreach ($collection as $weeklytaskUser) {

                $event = new WeeklytaskUserEvent($weeklytaskUser);
                $this->get('event_dispatcher')->dispatch('weeklytask_reminder_send', $event);
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