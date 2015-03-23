<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Command;

use Fitbase\Bundle\AufgabeBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class UserFocusImprovementCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:user-focus:improve')
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
        foreach ($repositoryUser->findAll() as $user) {
            if (($focus = $user->getFocus())) {
                if (($focusCategory = $focus->getFirstCategory())) {
                    if (($category = $focusCategory->getCategory())) {
                        if (in_array($category->getSlug(), array('ruecken'))) {

                            $output->writeln($user->getId());

                            $focusCategory->setPrimary($focus->getCategoryBySlug('oberer-rcken'));
                            $focusCategory->setType(0);

                            $this->getContainer()->get('entity_manager')->persist($focusCategory);
                            $this->getContainer()->get('entity_manager')->flush($focusCategory);
                        }
                    }
                }

            }
        }

    }
}