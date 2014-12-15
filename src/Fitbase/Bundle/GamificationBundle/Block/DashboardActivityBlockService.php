<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUser;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserForm;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardActivityBlockService extends BaseBlockService implements ContainerAwareInterface
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

        if (($focus = $this->container->get('focus')->focus($user))) {
            if (($focusCategory = $focus->getFirstCategory())) {
                if (($category = $focusCategory->getCategory())) {

                    if ($category->getSlug() == 'stress') {
                        $template = 'FitbaseGamificationBundle:Block:dashboard_activity_stress.html.twig';
                        return $this->renderPrivateResponse($template, array(
                            'user' => $user,
                        ));
                    }

                    if ($category->getSlug() == 'ernaehrung') {
                        $template = 'FitbaseGamificationBundle:Block:dashboard_activity_feeding.html.twig';
                        return $this->renderPrivateResponse($template, array(
                            'user' => $user,
                        ));
                    }

                }
            }
        }
        return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:dashboard_activity.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard Activity (Gamification)';
    }
} 