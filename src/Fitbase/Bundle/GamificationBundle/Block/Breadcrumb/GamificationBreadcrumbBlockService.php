<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\GamificationBundle\Block\Breadcrumb;

use Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb\FitbaseBreadcrumbBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

class GamificationBreadcrumbBlockService extends FitbaseBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.block.gamification.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $menu->addChild('Startseite', array(
            'path' => '/',
            'extras' => array(
                'translation_domain' => 'FitbaseGamificationBundle'
            ),
        ));

        return $menu;
    }
} 