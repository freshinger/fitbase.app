<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Fitbase\Bundle\FitbaseBUndle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;


/**
 * Class Builder
 *
 * @package Sonata\Bundle\DemoBundle\Menu
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class Builder extends ContainerAware
{
    /**
     * Creates the header menu
     *
     * @param FactoryInterface $factory
     * @param array $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
//        $isFooter = array_key_exists('is_footer', $options) ? $options['is_footer'] : false;
//
//        $shopCategories = $this->container->get('sonata.classification.manager.category')->findBy(array('enabled' => true, 'parent' => null));
//
        $menuOptions = array_merge($options, array(
            'childrenAttributes' => array('class' => 'nav nav-pills'),
        ));

        $menu = $factory->createItem('main', $menuOptions);
        $menu->addChild('Dashboard', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/'
            )
        ));
        $menu->addChild('Übungen', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/uebungen'
            )
        ));
        $menu->addChild('Theorie Einheiten', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/theorie-einheiten'
            )));

        $menu->addChild('Blog', array(
            'route' => 'sonata_news_archive',
        ));
        $menu->addChild('Übungen', array(
            'route' => 'exercises',
        ));

        $menu->addChild('Profil', array(
            'route' => 'sonata_user_profile_show',
        ));

//        $menu->addChild('Abmelden', array(
//            'route' => 'page_slug',
//            'routeParameters' => array(
//                'path' => '/logout'
//            )
//        ));


//        $shopMenuParams = array('route' => 'sonata_catalog_index');
//
//        if (count($shopCategories) > 0 && !$isFooter) {
//            $shopMenuParams = array_merge($shopMenuParams, array(
//                'attributes' => array('class' => 'dropdown'),
//                'childrenAttributes' => array('class' => 'dropdown-menu'),
//                'linkAttributes' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'data-target' => '#'),
//                'label' => 'Products <b class="caret caret-menu"></b>',
//                'extras' => array(
//                    'safe_label' => true,
//                )
//            ));
//        }
//
//
//        $shop = $menu->addChild('Shop', $shopMenuParams);
//
//        $menu->addChild('News', array('route' => 'sonata_news_home'));
//
//        foreach ($shopCategories as $category) {
//            $shop->addChild($category->getName(), array(
//                'route' => 'sonata_catalog_category',
//                'routeParameters' => array(
//                    'category_id'   => $category->getId(),
//                    'category_slug' => $category->getSlug()),
//                )
//            );
//        }
//
//        $extras = $factory->createItem('Discover', $dropdownExtrasOptions);
//
//        $extras->addChild('Bundles', array('route' => 'page_slug', 'routeParameters' => array('path' => '/bundles')));
//        $extras->addChild('Api', array('route' => 'page_slug', 'routeParameters' => array('path' => '/api-landing')));
//        $extras->addChild('Gallery', array('route' => 'sonata_media_gallery_index'));
//        $extras->addChild('Media & SEO', array('route' => 'sonata_demo_media'));
//
//        $menu->addChild($extras);


        return $menu;
    }
}
