<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Block;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

class DashboardBlock extends SecureBlockServiceAbstract
{

    protected $serviceUser;
    protected $serviceEntityManager;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $serviceUser, $serviceEntityManager)
    {
        parent::__construct($name, $roles, $templating, $securityContext);

        $this->serviceUser = $serviceUser;
        $this->serviceEntityManager = $serviceEntityManager;
    }


    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'weeklyquizUser' => null,
            'template' => 'Weeklytask/Block/Dashboard.html.twig',
        ));
    }


    /**
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return mixed
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {

        $user = $this->serviceUser->current();

        $countWeeklytaskDone = 0;
        $countWeeklytaskPointDone = 0;

        $weeklytaskUserRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        $weeklyquizUserRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

        $countWeeklytaskDone += $weeklytaskUserRepository->findCountByUserAndDone($user);
        $countWeeklytaskPointDone += $weeklytaskUserRepository->findSumPointByUserAndDone($user);
        $countWeeklytaskPointDone += $weeklyquizUserRepository->findSumPointByUserAndDone($user);


        $collection = $weeklytaskUserRepository->findAllByUser($user);
        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'countDone' => $countWeeklytaskDone,
            'countDonePoints' => $countWeeklytaskPointDone,
            'collection' => $collection,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Wochenaufgaben)';
    }

}