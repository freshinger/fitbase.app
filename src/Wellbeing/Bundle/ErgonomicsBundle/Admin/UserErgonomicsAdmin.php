<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wellbeing\Bundle\ErgonomicsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class UserErgonomicsAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('date')
            ->add('processed')
            ->add('processedDate')
            ->add('user')
            ->add('neck')
            ->add('bodyUpperForward')
            ->add('bodyUpperLean')
            ->add('bodyUpperRotation');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user')
            ->add('date')
            ->add('neck')
            ->add('bodyUpperForward')
            ->add('bodyUpperLean')
            ->add('bodyUpperRotation')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user')
            ->add('processed');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('date')
            ->add('processed')
            ->add('processedDate')
            ->add('user')
            ->add('neck')
            ->add('bodyUpperForward')
            ->add('bodyUpperLean')
            ->add('bodyUpperRotation');
    }
}