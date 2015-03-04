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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'company' => null,
            'template' => 'FitbaseUserBundle:Block:dashboard/user_registration.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $statistics = null;

        if (($company = $blockContext->getSetting('company'))) {
            $statistics = $this->getStatistics($company->getUsers(), $company->getActioncodes());
        }

        $done = isset($statistics['done']) ? $statistics['done'] : 0;
        $total = (isset($statistics['pause']) ? $statistics['pause'] : 0) + $done;

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'percent' => (float)$done / $total,
        ));
    }


    /**
     * Get statistical data
     *
     * @param null $questionnaire
     * @param null $users
     * @param null $actioncodes
     * @return array
     */
    protected function getStatistics($users = null, $actioncodes = null)
    {
        $statistic = array(
            'done' => 0,
            'pause' => 0,
        );

        if (count($users)) {
            foreach ($users as $user) {
                // Get assessment questionnaire for user from company
                $statistic['done']++;
                continue;
            }
        }

        // Potential users
        // mark not registered users as a
        // not processed questionnaire
        if (count($actioncodes)) {
            foreach ($actioncodes as $actioncode) {
                if (!$actioncode->getProcessed()) {
                    $statistic['pause']++;
                }
            }
        }

        if (array_sum($statistic) <= 0) {
            $statistic = array(
                'done' => 0,
                'pause' => 1,
            );
        }

        return $statistic;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 