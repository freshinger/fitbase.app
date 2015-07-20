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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Gamification/Dashboard/UserAvatar.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $translator = $this->container->get('translator');
        $formFactory = $this->container->get('form.factory');
        $user = $this->container->get('user')->current();

        $managerEntity = $this->container->get('entity_manager');
        $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');
        $repositoryUserActivity = $managerEntity->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserActivity');

        $activity = $repositoryUserActivity->findOneLastByUser($user);
        $gamification = $repositoryGamificationUser->findOneByUser($user);


        $form = $formFactory->create(new GamificationUserUpdateForm($translator), $gamification);
        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
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
        return 'User Avatar (Gamification dashboard)';
    }
} 