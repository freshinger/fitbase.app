<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Block\Breadcrumb;

use Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb\FitbaseBreadcrumbBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WeeklytasksBreadcrumbBlockService extends FitbaseBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.weeklytasks.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $menu->addChild('Infoeinheiten', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/infoeinheiten'
            ),
            'extras' => array('translation_domain' => 'FitbaseWeeklytaskBundle')
        ));


        return $menu;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        return $this->getRootMenu($blockContext);
    }
}