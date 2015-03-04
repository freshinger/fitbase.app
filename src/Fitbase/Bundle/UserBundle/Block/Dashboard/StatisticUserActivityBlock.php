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
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticUserActivityBlock extends SecureBlockService
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
        $statistics = array(
            'No users' => 1
        );

        if (($user = $this->serviceUser->current()) and ($company = $user->getCompany())) {
            $statistics = $this->toDiagramData($company->getUsers(), $company->getActioncodes());
        }

        return $this->renderPrivateResponse('FitbaseUserBundle:Block:dashboard/user_activity.html.twig', array(
            'statistics' => $statistics
        ));
    }

    /**
     * Convert data from data-layer to diagram-acceptable data
     * @param $users
     * @param $codes
     * @return array
     */
    protected function toDiagramData($users, $codes)
    {
        return array(
            'Aktivierte Benutzer' => count($users),
            'Noch nicht aktivierte Benutzer' => count($codes),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User statistic)';
    }
} 