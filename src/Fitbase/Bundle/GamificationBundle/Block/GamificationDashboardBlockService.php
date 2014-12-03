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
        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $managerEntity = $this->container->get('entity_manager');
        $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

        if (!($gamification = $repositoryGamificationUser->findOneByUser($user))) {
            return $this->executeAvatarForm($blockContext, $response);
        }

        return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:dashboard.html.twig', array());
    }

    /**
     * Display avatar choice form
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return Response
     */
    protected function executeAvatarForm(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($user = $this->container->get('user')->current())) {

            $managerEntity = $this->container->get('entity_manager');
            $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

            if (!($gamification = $repositoryGamificationUser->findOneByUser($user))) {
                $gamificationUser = new GamificationUser();
                $gamificationUser->setUser($user);

                $formType = new GamificationUserForm();
                $formType->setContainer($this->container);

                $form = $this->container->get('form.factory')->create($formType, $gamificationUser);
                if ($this->container->get('request')->get($form->getName())) {
                    $form->handleRequest($this->container->get('request'));
                    if ($form->isValid()) {

                        $eventGamificationUser = new GamificationUserEvent($gamificationUser);
                        $this->container->get('event_dispatcher')->dispatch('gamification_user_create', $eventGamificationUser);

                        return $this->execute($blockContext, $response);
                    }
                }

                return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:avatar.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $this->container->get('user')->current()
                ));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Gamification)';
    }
} 