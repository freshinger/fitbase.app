<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Block\Breadcrumb;

use Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb\FitbaseBreadcrumbBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class QuestionnaireCompanyPreviewBreadcrumb extends QuestionnaireCompanyBreadcrumb
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.breadcrumb.questionnaire.company.preview';
    }

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getMenu($blockContext);


        $menu->addChild('Vorshau', array(
            'route' => 'questionnaire_statistic_preview',
            'routeParameters' => array(
                'unique' => $this->container->get('request')->get('unique')
            )
        ));


        return $menu;
    }
} 