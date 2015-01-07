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

use Fitbase\Bundle\FitbaseBundle\Event\UserMenuEvent;
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

        $menuOptions = array_merge($options, array(
            'childrenAttributes' => array('class' => 'nav nav-pills'),
        ));

        $menu = $factory->createItem('main', $menuOptions);
        if (!($this->container->get('user')->current())) {
            return $menu;
        }


        $menu->addChild('Startseite', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/'
            )
        ));


        $this->container->get('event_dispatcher')
            ->dispatch('user_menu_main', new UserMenuEvent($menu));


        $menu->addChild('Infoeinheiten', array(
            'route' => 'page_slug',
            'routeParameters' => array(
                'path' => '/infoeinheiten'
            )));


        $menu->addChild('Profil', array(
            'route' => 'sonata_user_profile_show',
        ));

        return $menu;
    }
}
