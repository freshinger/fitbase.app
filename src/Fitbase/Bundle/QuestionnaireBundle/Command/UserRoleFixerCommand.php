<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Command;

use Fitbase\Bundle\AufgabeBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class UserRoleFixerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:user-role:fixer')
            ->setDescription('Questionnaire planner command, fill planning table by user data');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $managerEntity = $this->getContainer()->get('entity_manager');
        $repositoryUser = $managerEntity->getRepository('Application\Sonata\UserBundle\Entity\User');
        $repositoryGroup = $managerEntity->getRepository('Application\Sonata\UserBundle\Entity\Group');
        if (($group = $repositoryGroup->findOneByName('User'))) {
            foreach ($repositoryUser->findAll() as $user) {
                $user->addGroup($group);
                $managerEntity->persist($user);
                $managerEntity->flush($user);
            }
        }
    }
}