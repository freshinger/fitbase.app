<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block\Dashboard;


use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserForestBlock extends BaseBlockService implements ContainerAwareInterface
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
            'template' => 'Gamification/Dashboard/UserForest.html.twig',
        ));
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

        $points = 0;
        if (($company = $user->getCompany())) {
            if (($users = $company->getUsers())) {
                foreach ($users as $user) {
                    if (($pointsUser = $this->container->get('statistic')->points($user))) {
                        $points += $pointsUser;
                    }
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'points' => $points,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User forest (Gamification dashboard)';
    }
} 