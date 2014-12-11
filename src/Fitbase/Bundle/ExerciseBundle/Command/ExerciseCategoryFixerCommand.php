<?php
namespace Fitbase\Bundle\ExerciseBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExerciseCategoryFixerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:exercise:category-fixer')
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
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        foreach ($repositoryExercise->findAll() as $exercise) {
            $output->writeln($exercise->getName());

            if (!count($exercise->getCategories())) {
                $exercise->addCategory($exercise->getCategory());

                try {
                    $entityManager->persist($exercise);
                    $entityManager->flush($exercise);

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