<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block;


use Fitbase\Bundle\GamificationBundle\Form\GamificationUserUpdateForm;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardAvatarBlockService extends BaseBlockService implements ContainerAwareInterface
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

        $managerEntity = $this->container->get('entity_manager');
        $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

        if (!($gamification = $repositoryGamificationUser->findOneByUser($user))) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('form.factory')->create(new GamificationUserUpdateForm(), $gamification);
        return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:DashboardAvatar.html.twig', array(
            'form' => $form->createView(),
            'gamification' => $gamification,
            'avatar' => $this->container->get('gamification')->getSvgAvatar($gamification),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard Avatar (Gamification)';
    }
} 