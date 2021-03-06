<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Abstract class for breadcrumb menu services.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class FitbaseBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        parent::setDefaultSettings($resolver);

        $resolver->setDefaults(array(
            'menu_template' => 'FitbaseFitbaseBundle:Menu:breadcrumb.html.twig',
            'include_homepage_link' => true,
        ));
    }

    /**
     * Initialize breadcrumb menu.
     *
     * @param BlockContextInterface $blockContext
     *
     * @return ItemInterface
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $blockContext->setSetting('include_homepage_link', false);

        $menu = parent::getRootMenu($blockContext);
        $menu->setChildrenAttribute('class', 'breadcrumb');

        $menu->addChild('Startseite', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/'
            )));
        return $menu;
    }
}
