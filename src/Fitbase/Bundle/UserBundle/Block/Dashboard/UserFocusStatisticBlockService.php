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


class UserFocusStatisticBlockService extends SecureBlockService
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
            'Empty' => 1,
        );

        if (($user = $this->serviceUser->current())) {
            if (($company = $user->getCompany())) {
                if (($collection = $company->getUsers())) {
                    $statistics = $this->toDiagramData($collection);
                }
            }
        }


        return $this->renderPrivateResponse('FitbaseUserBundle:Block:dashboard/focus_statistic.html.twig', array(
            'statistics' => $statistics
        ));
    }


    /**
     * Convert data from data-layer to diagram-acceptable data
     * @param $collection
     * @return array
     */
    protected function toDiagramData($collection)
    {
        $result = array();

        foreach ($collection as $user) {
            if (($focus = $user->getFocus())) {
                if (($focusCategory = $focus->getFirstCategory())) {
                    if (!isset($result[$focusCategory->__toString()])) {
                        $result[$focusCategory->__toString()] = 0;
                    }

                    $result[$focusCategory->__toString()]++;
                }
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 