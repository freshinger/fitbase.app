<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wellbeing\Bundle\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class UserStateAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('user')
            ->add('date')
            ->add('head', null, array(
                'template' => 'WellbeingApiBundle:Admin:ShowHead.html.twig'
            ))
            ->add('shoulderLeft')
            ->add('shoulderCenter')
            ->add('shoulderRight')
            ->add('elbowLeft')
            ->add('elbowRight')
            ->add('handLeft')
            ->add('handRight')
            ->add('com')
            ->add('spine')
            ->add('hipLeft')
            ->add('hipRight')
            ->add('kneeLeft')
            ->add('kneeRight')
            ->add('footLeft')
            ->add('footRight');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user')
            ->add('date')
            ->add('head', null, array(
                'template' => 'WellbeingApiBundle:Admin:ListHead.html.twig'
            ))
//            ->add('shoulderLeft')
//            ->add('shoulderCenter')
//            ->add('shoulderRight')
//            ->add('elbowLeft')
//            ->add('elbowRight')
//            ->add('handLeft')
//            ->add('handRight')
//            ->add('com')
//            ->add('spine')
//            ->add('hipLeft')
//            ->add('hipRight')
//            ->add('kneeLeft')
//            ->add('kneeRight')
//            ->add('footLeft')
//            ->add('footRight')
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
            ->add('date')
            ->add('head')
            ->add('shoulderLeft')
            ->add('shoulderCenter')
            ->add('shoulderRight')
            ->add('elbowLeft')
            ->add('elbowRight')
            ->add('handLeft')
            ->add('handRight')
            ->add('com')
            ->add('spine')
            ->add('hipLeft')
            ->add('hipRight')
            ->add('kneeLeft')
            ->add('kneeRight')
            ->add('footLeft')
            ->add('footRight');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('user')
            ->add('date')
            ->add('head')
            ->add('shoulderLeft')
            ->add('shoulderCenter')
            ->add('shoulderRight')
            ->add('elbowLeft')
            ->add('elbowRight')
            ->add('handLeft')
            ->add('handRight')
            ->add('com')
            ->add('spine')
            ->add('hipLeft')
            ->add('hipRight')
            ->add('kneeLeft')
            ->add('kneeRight')
            ->add('footLeft')
            ->add('footRight');
    }
}