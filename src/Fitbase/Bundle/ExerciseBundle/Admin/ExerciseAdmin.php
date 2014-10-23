<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\ExerciseBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ExerciseAdmin extends Admin implements ContainerAwareInterface
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
            ->add('tag')
            ->add('countPoint')
            ->end()
            ->with('Content', array('class' => 'col-md-6'))
            ->add('description', null, array(
                'safe' => true,
                'template' => 'FitbaseExerciseBundle:Admin:show_content.html.twig'
            ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('image', null, array(
                'label' => 'Vorschaubild',
                'template' => 'FitbaseExerciseBundle:Admin:list_image.html.twig'
            ))
            ->add('name')
            ->add('tag')
            ->add('countPoint')
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
            ->add('tag')
            ->add('countPoint');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
            ->add('tag')
            ->add('countPoint')
            ->end()
            ->with('Media', array('class' => 'col-md-6'))
            ->add('video', 'sonata_type_model_list', array('required' => false), array('link_parameters' => array('context' => 'exercise')))
            ->add('image', 'sonata_type_model_list', array('required' => false), array('link_parameters' => array('context' => 'exercise')))
            ->add('gallery', 'sonata_type_model_list', array('required' => false), array('link_parameters' => array('context' => 'exercise')))
            ->end()
            ->with('Content', array('class' => 'col-md-12'))
            ->add('description', 'sonata_formatter_type', array(
                'event_dispatcher' => $this->container->get('event_dispatcher'),
                'format_field' => 'format',
                'source_field' => 'description',
                'source_field_options' => array(
                    'attr' => array('class' => 'span10', 'rows' => 80)
                ),
                'listener' => true,
                'target_field' => 'content',
                'label' => 'Content'
            ))
            ->end();
    }
}