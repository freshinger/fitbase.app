<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockService;
use Fitbase\Bundle\FitbaseBundle\Service\ServiceUser;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticUserRegistrationBlock extends SecureBlockService
{
    protected $serviceUser;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, ServiceUser $serviceUser)
    {
        parent::__construct($name, $roles, $templating, $securityContext);
        $this->serviceUser = $serviceUser;
    }


    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {

        return $this->renderPrivateResponse('FitbaseUserBundle:Block:dashboard/user_registration.html.twig', array());
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 