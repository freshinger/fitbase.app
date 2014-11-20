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

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserAdmin extends BaseUserAdmin implements ContainerAwareInterface
{
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('company')
            ->add('enabled', null, array('editable' => true))
            ->add('locked', null, array('editable' => true))
            ->add('createdAt');

        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $listMapper
                ->add('impersonating', 'string', array('template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig'));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('company');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('company', null, array('required' => true))
            ->add('firstname', null, array('required' => true))
            ->add('lastname', null, array('required' => true))
            ->add('email')
            ->add('username', 'hidden', array(
                'required' => true,
                'data' => $this->container->get('codegenerator')->password(8)
            ))
            ->add('plainPassword', 'text', array(
                'required' => true,
                'read_only' => true,
                'data' => $this->container->get('codegenerator')->password(8)
            ))
            ->add('focus', null, array('required' => true))
            ->end()
            ->with('Profile', array('class' => 'col-md-6'))
            ->add('gender', 'sonata_user_gender', array(
                'required' => false,
                'translation_domain' => $this->getTranslationDomain()
            ))
            ->add('phone', null, array('required' => false))
            ->end();
    }
}
