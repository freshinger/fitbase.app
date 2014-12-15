<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block;


use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardFocusBlockService extends BaseBlockService implements ContainerAwareInterface
{
    /**
     * Store container here
     * @var
     */
    protected $container;

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->container->get('entity_manager');
        $weeklytaskUserRepository = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        $collectionWeeklytaskActual = $weeklytaskUserRepository->findAllByUserAndNotDone($user, 3);

        $category = null;
        if (($focus = $this->container->get('focus')->focus($user))) {
            if (($focusCategory = $focus->getFirstCategory())) {
                $category = $focusCategory->getCategory();
            }
        }


        return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:dashboard_focus.html.twig', array(
            'user' => $user,
            'category' => $category,
            'nextWeeklytask' => $this->getNextIntervalWeeklytask($user),

            'collection' => $collectionWeeklytaskActual,
        ));
    }

    /**
     * Get next
     * @param $user
     * @return int
     */
    protected function getNextIntervalWeeklytask($user)
    {
        $dayNext = 0;
        $dayCurrent = 0;

        if (($datetime = $this->container->get('datetime')->getDateTime('now'))) {

            $dayNext = (int)$datetime->format('N');
            $dayCurrent = (int)$datetime->format('N');

            $entityManager = $this->container->get('entity_manager');
            $repositoryReminderUserItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');

            if (($collection = $repositoryReminderUserItem->findAllByUserAndType($user, 'weeklytask'))) {
                $dayNext = min($collection)->getDay();
                foreach ($collection as $key => $reminderUserItem) {
                    if (($day = $reminderUserItem->getDay()) > $dayCurrent) {
                        $dayNext = $day;
                        break;
                    }
                }
            }
        }

        return abs($dayNext - $dayCurrent);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard Focus (Gamification)';
    }
} 