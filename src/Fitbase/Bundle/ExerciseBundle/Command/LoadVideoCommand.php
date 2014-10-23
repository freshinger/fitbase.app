<?php
namespace Fitbase\Bundle\ExerciseBundle\Command;

use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class LoadVideoCommand extends ContainerAwareCommand
{
    /**
     * Configure current task
     *
     */
    protected function configure()
    {
        $this->setName('fitbase:load:media')
            ->setDescription('Load Fitbase-Video command');
    }


    public function loadFixtures($dir, $append = true)
    {
        $kernel = $this->getContainer()->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);

        //Loading Fixtures
        $options = array('command' => 'doctrine:fixtures:load', "--fixtures" => $dir, "--append" => (boolean)$append);
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->loadFixtures('src/Fitbase/Bundle/ExerciseBundle/DataFixtures/ORM/');
    }
}
