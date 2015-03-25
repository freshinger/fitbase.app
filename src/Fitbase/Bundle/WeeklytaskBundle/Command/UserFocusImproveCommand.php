<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;


class UserFocusImproveCommand extends ContainerAwareCommand
{
    /**
     * Configure current console task
     */
    protected function configure()
    {
        $this->setName('fitbase:user-focus:improve')
            ->setDescription('Create Weeklyquiz-User association');
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
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');
        foreach ($repositoryUser->findAll() as $user) {
            if (($focus = $user->getFocus())) {
                if (($userFocusCategory = $focus->getCategoryBySlug('ruecken'))) {
                    $output->writeln($focus->__toString());

                    $userFocusCategory->setType(0);
                    $entityManager->persist($userFocusCategory);

                    if (($primary = $focus->getCategoryBySlug('oberer-ruecken'))) {
                        $primary->setType(0);
                        $primary->setParent($userFocusCategory);
                        $entityManager->persist($primary);
                    }

                    if (($primary = $focus->getCategoryBySlug('unterer-ruecken'))) {
                        $primary->setType(0);
                        $primary->setParent($userFocusCategory);
                        $entityManager->persist($primary);
                    }

                    if (($primary = $focus->getCategoryBySlug('mittlerer-ruecken'))) {
                        $primary->setType(0);
                        $primary->setParent($userFocusCategory);
                        $entityManager->persist($primary);
                    }

                    if (($primary = $focus->getCategoryBySlug('thera-band'))) {
                        $primary->setType(0);
                        $primary->setParent($userFocusCategory);
                        $entityManager->persist($primary);
                    }
                }
            }
        }
        $entityManager->flush();
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