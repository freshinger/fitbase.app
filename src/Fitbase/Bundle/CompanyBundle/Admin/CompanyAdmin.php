<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\CompanyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CompanyAdmin extends Admin implements ContainerAwareInterface
{
    protected $container;

    /**
     * Set service container to admin class
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
            ->add('site')
            ->add('description')
            ->end()
            ->with('Logo', array('class' => 'col-md-6'))
            ->add('logo')
            ->add('logoWidth')
            ->add('logoHeight')
            ->end()
            ->with('Style', array('class' => 'col-md-6'))
            ->add('colorHeader')
            ->add('colorFooter')
            ->add('colorBackground')
            ->end()
            ->with('Extra', array('class' => 'col-md-6'))
            ->add('questionnaire')
            ->add('gamification')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('site')
            ->add('date')
            ->add('questionnaire')
            ->add('gamification')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('site');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name')
            ->add('site')
            ->add('date', 'sonata_type_datetime_picker')
            ->add('description')
            ->end()
            ->with('Logo', array('class' => 'col-md-6'))
            ->add('logo')
            ->add('logoWidth')
            ->add('logoHeight')
            ->end()
            ->with('Style', array('class' => 'col-md-6'))
            ->add('colorHeader', 'genemu_jquerycolor')
            ->add('colorFooter', 'genemu_jquerycolor')
            ->add('colorBackground', 'genemu_jquerycolor')
            ->end()
            ->with('Extra', array('class' => 'col-md-6'))
            ->add('questionnaire')
            ->add('gamification')
            ->end();
    }
}