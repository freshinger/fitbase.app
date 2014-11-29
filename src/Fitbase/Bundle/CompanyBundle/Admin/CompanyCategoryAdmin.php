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

use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CompanyCategoryAdmin extends Admin implements ContainerAwareInterface
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
    public function postPersist($object)
    {
        $event = new CompanyCategoryEvent($object);
        $this->container->get('event_dispatcher')->dispatch('company_category_update', $event);
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $event = new CompanyCategoryEvent($object);
        $this->container->get('event_dispatcher')->dispatch('company_category_update', $event);
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove($object)
    {
        $event = new CompanyCategoryEvent($object);
        $this->container->get('event_dispatcher')->dispatch('company_category_remove', $event);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('company')
            ->add('category')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('company')
            ->add('category')
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
            ->add('company')
            ->add('category');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('company')
            ->add('category')
            ->end();
    }
}