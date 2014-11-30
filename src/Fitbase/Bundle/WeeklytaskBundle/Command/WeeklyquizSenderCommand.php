<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklyquizSenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklyquiz:sender')
            ->setDescription('Weekly quiz sender command, send queue from planning table');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $context = $this->getContainer()->get('router')->getContext();
        $context->setHost('app.fitbase.de');
        $context->setScheme('http');

        $datetime = $this->get('datetime')->getDateTime('now');
        if (($collection = $this->get('weeklyquiz')->toSend($datetime))) {
            foreach ($collection as $weeklyquizUser) {

                $event = new WeeklyquizUserEvent($weeklyquizUser);
                $this->get('event_dispatcher')->dispatch('weeklyquiz_reminder_send', $event);
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