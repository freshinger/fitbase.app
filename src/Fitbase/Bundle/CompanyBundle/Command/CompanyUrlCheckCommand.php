<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\CompanyBundle\Command;


use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CompanyUrlCheckCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:company:url-check')
            ->setDescription('Show urls for different users to check correctness');
    }

    /**
     * Execute task
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $router = $this->getContainer()->get('twig.extension.routing');

        $entityManager = $this->getContainer()->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');
        $user = $repositoryUser->find(1);


        $output->writeln($router->getUrl('dashboard', array(), UrlGeneratorInterface::ABSOLUTE_PATH, $user->getCompany()));
    }
}