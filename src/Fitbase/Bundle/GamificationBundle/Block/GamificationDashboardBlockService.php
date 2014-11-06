<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block;


use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationDashboardBlockService extends BaseBlockService implements ContainerAwareInterface
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
        $points = null;
        $statistic = null;
        $gamification = null;
        if (($user = $this->container->get('user')->current())) {
            $managerEntity = $this->container->get('entity_manager');
            $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

            if (($gamification = $repositoryGamificationUser->findOneByUser($user))) {
                $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');
                if (($gamificationUserPointlog = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
                    $points = $gamificationUserPointlog->getCountPointTotal();
                }

                $datetime = $this->container->get('datetime')->getDateTime('now');
                $datetime->modify('-12 week');

                if (($statistic = $repositoryGamificationUserPointlog->findAllByUserGroupByWeek($user, $datetime))) {
                    foreach ($statistic as $index => $element) {
                        $statistic[$index]['date'] = $this->container->get('datetime')->getDateTime($element['date']);
                    }
                }
            }
        }

        return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:dashboard.html.twig', array(
            'points' => $points,
            'statistic' => $statistic,
            'gamification' => $gamification,
            'avatar' => $this->container->get('gamification')->getSvgAvatar($gamification),
            'tree' => $this->container->get('gamification')->getSvgTree($gamification),
            'forest' => $this->container->get('gamification')->getSvgForest($gamification),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Gamification)';
    }
} 