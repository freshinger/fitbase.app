<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFocusAdmin extends Admin implements ContainerAwareInterface
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
    public function postUpdate($object)
    {
        // Attach automatically parent
        // focus category to current focus category
        // if real category has a parent and
        // this parent was attached to focus
        if (($focusCategories = $object->getCategories())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryUserFocusCategory = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocusCategory');
            foreach ($focusCategories as $focusCategory) {
                if (($category = $focusCategory->getCategory())) {
                    if (($parentCategory = $category->getParent())) {
                        if (($parentFocusCategory = $repositoryUserFocusCategory->findOneByCategory($parentCategory))) {
                            $focusCategory->setParent($parentFocusCategory);
                            $entityManager->persist($focusCategory);
                        }
                    }
                }
            }
            $entityManager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('user')
            ->add('name')
            ->add('description')
            ->add('categories')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user')
            ->add('name')
            ->add('description')
            ->add('categories')
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
            ->add('user');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-4'))
            ->add('user')
            ->add('name')
            ->add('description')
            ->end()
            ->with('Categories', array('class' => 'col-md-8'))
            ->add('categories', 'sonata_type_collection', array(
                'label' => false,
                'type_options' => array(
                    'delete' => true,
                    'delete_options' => array(
                        'type' => 'checkbox',
                        'type_options' => array(
                            'mapped' => false,
                            'required' => false,
                        )
                    )
                )
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
            ))
            ->end();
    }
}
