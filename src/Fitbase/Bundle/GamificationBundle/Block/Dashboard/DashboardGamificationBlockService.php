<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block\Dashboard;


use Doctrine\Common\Persistence\ObjectManager;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockService;
use Fitbase\Bundle\FitbaseBundle\Service\ServiceUser;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUser;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserForm;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class DashboardGamificationBlockService extends SecureBlockService
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
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $repositoryGamificationUser = $this->objectManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

        if (!($gamification = $repositoryGamificationUser->findOneByUser($this->serviceUser->current()))) {
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
        if (($user = $this->serviceUser->current())) {

            $gamificationUser = new GamificationUser();
            $gamificationUser->setUser($user);

            $formType = new GamificationUserForm(
                $this->templating,
                $this->gamification
            );

            $form = $this->formFactory->create($formType, $gamificationUser);
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