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
class Builder extends ContainerAware implements BuilderMenuInterface
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
        $securityContext = $this->container->get('security.context');

        $builder = null;
        if ($securityContext->isGranted('ROLE_FITBASE_COMPANY')) {
            $builder = new BuilderMenuCompany();
            $builder->setContainer($this->container);
            return $builder->mainMenu($factory, $options);

        }
        if ($securityContext->isGranted('ROLE_FITBASE_USER')) {
            $builder = new BuilderMenuUser();
            $builder->setContainer($this->container);
            return $builder->mainMenu($factory, $options);
        }

        return $factory->createItem('main', array_merge($options, array(
            'childrenAttributes' => array('class' => 'nav nav-pills'),
        )));
    }
}
