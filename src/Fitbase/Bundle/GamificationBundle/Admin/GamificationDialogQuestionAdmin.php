<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\GamificationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class GamificationDialogQuestionAdmin extends Admin implements ContainerAwareInterface
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
            ->add('text')
            ->add('type')
            ->add('start')
            ->add('positive')
            ->end()
            ->with('Folgende Fragen', array('class' => 'col-md-6'))
            ->add('questionTrue')
            ->add('questionFalse')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('text', null, array(
                'template' => 'FitbaseGamificationBundle:Admin:question_list_text.html.twig'
            ))
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
            ->add('text')
            ->add('type')
            ->add('start')
            ->add('positive');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('text')
            ->add('description', null, array(
                'required' => false,
            ))
            ->add('type')
            ->add('start', 'checkbox', array(
                'required' => false,

            ))
            ->add('positive', 'checkbox', array(
                'required' => false,

            ))
            ->end()
            ->with('Folgende Fragen', array('class' => 'col-md-6'))
            ->add('questionTrue')
            ->add('questionFalse')
            ->end();
    }
}