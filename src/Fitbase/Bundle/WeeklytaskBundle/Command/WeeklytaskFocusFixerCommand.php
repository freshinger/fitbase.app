<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklytaskFocusFixerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:focus-fixer')
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
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        foreach ($repositoryUser->findAll() as $user) {

            $repositoryUserFocus = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocus');
            if ($repositoryUserFocus->findOneByUser($user)) {
                continue;
            }


            $entityFocus = new UserFocus();
            $entityFocus->setUser($user);

            $entityManager->persist($entityFocus);
            $entityManager->flush($entityFocus);


            if (($category = $user->getFocus())) {

                $entityFocusCategory = new UserFocusCategory();
                $entityFocusCategory->setFocus($entityFocus);
                $entityFocusCategory->setCategory($category);
                $entityFocusCategory->setPriority(1);

                $entityManager->persist($entityFocusCategory);
                $entityManager->flush($entityFocusCategory);

                $entityFocus->addCategory($entityFocusCategory);

                $entityManager->persist($entityFocus);
                $entityManager->flush($entityFocus);


                if (($children = $category->getChildren())) {

                    foreach ($children as $priority => $childCategory) {

                        $entityFocusChildCategory = new UserFocusCategory();
                        $entityFocusChildCategory->setFocus($entityFocus);
                        $entityFocusChildCategory->setCategory($childCategory);
                        $entityFocusChildCategory->setPriority($priority + 1);
                        $entityFocusChildCategory->setParent($entityFocusCategory);

                        $entityManager->persist($entityFocusChildCategory);
                        $entityManager->flush($entityFocusChildCategory);

                        $entityFocus->addCategory($entityFocusChildCategory);

                        $entityManager->persist($entityFocus);
                        $entityManager->flush($entityFocus);
                    }

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