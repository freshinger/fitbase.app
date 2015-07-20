<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Fitbase\Bundle\FitbaseBundle\Menu;

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
class BuilderMenuUser extends ContainerAware implements BuilderMenuInterface
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
        $translator = $this->container->get('translator');
        $eventDispatcher = $this->container->get('event_dispatcher');

        $menu = $factory->createItem('main', array_merge($options, array(
            'childrenAttributes' => array(
                'class' => 'fitbase-menu flexnav',
                'data-breakpoint' => "992",
            ),
        )));

        $menu->addChild($translator->trans('fitbase.dashboard', [], 'FitbaseFitbaseBundle'), [
            'route' => 'dashboard'
        ]);

        $event = new UserMenuEvent($menu);
        $eventDispatcher->dispatch('fitbase.user_menu', $event);

        $menu->addChild($translator->trans('fitbase.profile', [], 'FitbaseFitbaseBundle'), [
            'route' => 'profile',
        ]);

        $menu->addChild($translator->trans('fitbase.logout', [], 'FitbaseFitbaseBundle'), [
            'route' => 'page_slug',
            'routeParameters' => [
                'path' => '/logout'
            ]
        ]);

        return $menu;
    }
}
