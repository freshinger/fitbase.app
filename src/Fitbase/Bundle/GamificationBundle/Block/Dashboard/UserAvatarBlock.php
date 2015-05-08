<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block\Dashboard;


use Fitbase\Bundle\GamificationBundle\Form\GamificationUserUpdateForm;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserAvatarBlock extends BaseBlockService implements ContainerAwareInterface
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
        $user = $this->container->get('user')->current();

        $managerEntity = $this->container->get('entity_manager');
        $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');
        $repositoryUserActivity = $managerEntity->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserActivity');

        $activity = $repositoryUserActivity->findOneLastByUser($user);
        $gamification = $repositoryGamificationUser->findOneByUser($user);


        $form = $this->container->get('form.factory')->create(new GamificationUserUpdateForm(), $gamification);
        return $this->renderPrivateResponse('Gamification/Dashboard/DashboardAvatar.html.twig', array(
            'activity' => $activity,
            'gamification' => $gamification,
            'form' => $form->createView(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Avatar (Gamification)';
    }
} 