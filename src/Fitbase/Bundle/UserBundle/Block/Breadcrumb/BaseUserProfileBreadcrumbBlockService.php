<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\UserBundle\Block\Breadcrumb;

use Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb\FitbaseBreadcrumbBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;

/**
 * Abstract class for user breadcrumbs.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseUserProfileBreadcrumbBlockService extends FitbaseBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $menu->addChild('Profil', array(
            'route' => 'profile',
            'extras' => array('translation_domain' => 'SonataUserBundle')
        ));

        return $menu;
    }
}
