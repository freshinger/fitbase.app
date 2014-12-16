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

use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Form\UserFocusCategoryForm;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFocusCategoryAdmin extends Admin implements ContainerAwareInterface
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
        $entityManager = $this->container->get('entity_manager');
        $repositoryUserFocusCategory = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocusCategory');

        if (($category = $object->getCategory())) {
            $parentCategory = null;
            if (($parentCategory = $category->getParent())) {
                if (!($parentFocusCategory = $repositoryUserFocusCategory->findOneByCategory($parentCategory))) {
                    // TODO: ...
                }
            }
            $object->setParent($parentFocusCategory);
            $entityManager->persist($object);
        }

        $entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('focus')
            ->add('category')
            ->add('priority')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('focus')
            ->add('category')
            ->add('parent')
            ->add('priority')
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
            ->add('focus')
            ->add('category')
            ->add('priority');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-4'))
            ->add('focus')
            ->add('category')
            ->add('priority')
            ->end();
    }
}
