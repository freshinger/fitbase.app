<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block;


use Doctrine\Common\Persistence\ObjectManager;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Fitbase\Bundle\FitbaseBundle\Service\ServiceUser;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUser;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserUpdateForm;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class DashboardGamificationBlockService extends SecureBlockServiceAbstract
{
    protected $serviceUser;
    protected $objectManager;
    protected $formFactory;
    protected $request;
    protected $eventDispatcher;
    protected $gamification;

    public function __construct($name, array $roles = array(), EngineInterface $templating,
                                SecurityContextInterface $securityContext, ServiceUser $serviceUser, ObjectManager $objectManager,
                                $formFactory, $request, $eventDispatcher, $gamification)
    {
        parent::__construct($name, $roles, $templating, $securityContext);

        $this->serviceUser = $serviceUser;
        $this->objectManager = $objectManager;
        $this->formFactory = $formFactory;
        $this->request = $request;
        $this->eventDispatcher = $eventDispatcher;
        $this->gamification = $gamification;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $repositoryGamificationUser = $this->objectManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');
        if (($gamification = $repositoryGamificationUser->findOneByUser($this->serviceUser->current()))) {
            $form = $this->formFactory->create(new GamificationUserUpdateForm(), $gamification);
            if ($this->request->get($form->getName())) {
                $form->handleRequest($this->request);
                if ($form->isValid()) {

                    $gamification->setUpdate(true);
                    $this->objectManager->persist($gamification);
                    $this->objectManager->flush($gamification);
                }
            }
        }

        if ((!$gamification instanceof GamificationUser) or $gamification->getUpdate()) {
            return $this->renderAvatarForm($blockContext, $response);
        }

        return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:dashboard.html.twig', array());
    }


    /**
     * Display avatar choice form
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return Response
     */
    protected function renderAvatarForm(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($user = $this->serviceUser->current())) {

            $gamificationUser = new GamificationUser();
            $gamificationUser->setUser($user);

            $form = $this->formFactory->create(new GamificationUserForm(), $gamificationUser);
            if ($this->request->get($form->getName())) {
                $form->handleRequest($this->request);
                if ($form->isValid()) {

                    $eventGamificationUser = new GamificationUserEvent($gamificationUser);
                    $this->eventDispatcher->dispatch('gamification_user_create', $eventGamificationUser);

                    return $this->execute($blockContext, $response);
                }
            }

            return $this->renderPrivateResponse('FitbaseGamificationBundle:Block:dashboard\avatar.html.twig', array(
                'form' => $form->createView(),
                'user' => $this->serviceUser->current()
            ));
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