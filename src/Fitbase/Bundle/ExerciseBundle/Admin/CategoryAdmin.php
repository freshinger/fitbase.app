<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Sonata Project <https://github.com/sonata-project/SonataClassificationBundle/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\ExerciseBundle\Admin;

use Fitbase\Bundle\ExerciseBundle\Event\CategoryEvent;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\ClassificationBundle\Admin\CategoryAdmin as BaseCategoryAdmin;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CategoryAdmin extends BaseCategoryAdmin implements ContainerAwareInterface
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
        $event = new CategoryEvent($object);
        $this->container->get('event_dispatcher')->dispatch('category_created', $event);
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $event = new CategoryEvent($object);
        $this->container->get('event_dispatcher')->dispatch('category_updated', $event);
    }

    /**
     * {@inheritdoc}
     */
    public function preRemove($object)
    {
        $event = new CategoryEvent($object);
        $this->container->get('event_dispatcher')->dispatch('category_removed', $event);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                'template' => 'FitbaseExerciseBundle:Admin:category_image.html.twig'
            ))
            ->add('parent')
            ->add('slug')
            ->add('description')
            ->add('position')
            ->add('enabled', null, array('editable' => true));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('enabled')
            ->add('parent');
    }


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
            ->add('label', null, array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->end()
            ->with('Options', array('class' => 'col-md-6'))
            ->add('enabled')
            ->add('position', 'integer', array('required' => false))
            ->add('parent', 'sonata_category_selector', array(
                'category' => $this->getSubject() ?: null,
                'model_manager' => $this->getModelManager(),
                'class' => $this->getClass(),
                'required' => false
            ))
            ->end()
            ->with('General')
            ->add('slug')
            ->add('media', 'sonata_type_model_list',
                array('required' => false),
                array(
                    'link_parameters' => array(
                        'provider' => 'sonata.media.provider.image',
                        'context' => 'category',
                    )
                )
            )
            ->end();
    }
}
