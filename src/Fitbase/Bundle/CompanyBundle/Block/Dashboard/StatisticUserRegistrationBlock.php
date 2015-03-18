<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticUserRegistrationBlock extends SecureBlockServiceAbstract
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'company' => null,
            'template' => 'FitbaseCompanyBundle:Block:Dashboard/user_registration.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
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