<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklytaskCategoryFixerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:category-fixer')
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
        $entityManager = $this->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        foreach ($repositoryWeeklytask->findAll() as $weeklytask) {
            $output->writeln($weeklytask->getName());

            if (!count($weeklytask->getCategories())) {
                $weeklytask->addCategory($weeklytask->getCategory());

                try {
                    $entityManager->persist($weeklytask);
                    $entityManager->flush($weeklytask);

                } catch (\Exception $ex) {
                    $output->writeln($ex->getMessage());

                }
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