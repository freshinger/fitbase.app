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

use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
    public function prePersist($object)
    {
        $event = new UserEvent($object);
        $this->container->get('event_dispatcher')->dispatch('user_create', $event);
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $event = new UserEvent($object);
        $this->container->get('event_dispatcher')->dispatch('user_created', $event);
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $event = new UserEvent($object);
        $this->container->get('event_dispatcher')->dispatch('user_updated', $event);
    }

    /**
     * Create new object instance
     * @return mixed|void
     */
    public function getNewInstance()
    {
        if (($object = parent::getNewInstance())) {
            do {
                $code = $this->container->get('codegenerator')->password(5);
                $object->setUsername("benutzer_" . strtolower($code));
            } while ($this->container->get('user')->username($object->getUsername()));
            $object->setEnabled(true);
            $object->setPlainPassword($this->container->get('codegenerator')->password(8));

            return $object;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
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
            ->tab('General')
            ->with('General', array('class' => 'col-md-6'))
            ->add('company', null, array('required' => true))
            ->add('firstname', null, array('required' => true))
            ->add('lastname', null, array('required' => true))
            ->add('email')
            ->add('username', 'text', array(
                'required' => true,
            ))
            ->add('plainPassword', 'text', array(
                'required' => false,
                'read_only' => true,
            ))
            ->add('focus', null, array('required' => true))
            ->end()
            ->with('Profile', array('class' => 'col-md-6'))
            ->add('enabled')
            ->add('gender', 'sonata_user_gender', array(
                'required' => false,
                'translation_domain' => $this->getTranslationDomain()
            ))
            ->add('phone', null, array('required' => false))
            ->end()
            ->end()
            ->tab('Rechte')
            ->with('Gruppen', array('class' => 'col-md-6'))
            ->add('groups', 'sonata_type_model', array(
                'required' => false,
                'expanded' => true,
                'multiple' => true
            ))
            ->end()
            ->with('Management', array('class' => 'col-md-6'))
            ->add('realRoles', 'sonata_security_roles', array(
                'label' => 'form.label_roles',
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ))
            ->end()
            ->end()
            ->tab('Sicherheit')
            ->with('Flags', array('class' => 'col-md-6'))
            ->add('locked', null, array('required' => false))
            ->add('expired', null, array('required' => false))
            ->add('enabled', null, array('required' => false))
            ->add('credentialsExpired', null, array('required' => false))
            ->end()
            ->with('Security', array('class' => 'col-md-6'))
            ->add('token', null, array('required' => false))
            ->add('twoStepVerificationCode', null, array('required' => false))
            ->end()
            ->end()
            ->tab('Profile')
            ->with('Profile', array('class' => 'col-md-6'))
            ->add('dateOfBirth', 'sonata_type_date_picker')
            ->add('website', 'url', array('required' => false))
            ->add('facebookUid', null, array('required' => false))
            ->add('facebookName', null, array('required' => false))
            ->add('twitterUid', null, array('required' => false))
            ->add('twitterName', null, array('required' => false))
            ->add('gplusUid', null, array('required' => false))
            ->add('gplusName', null, array('required' => false))
            ->end()
            ->with('Biography', array('class' => 'col-md-6'))
            ->add('biography', 'sonata_formatter_type', array(
                'required' => false,
                'event_dispatcher' => $this->container->get('event_dispatcher'),
                'format_field' => 'format',
                'source_field' => 'biography',
                'source_field_options' => array(
                    'attr' => array('class' => 'span10', 'rows' => 80)
                ),
                'listener' => true,
                'target_field' => 'content',
                'label' => 'Content'
            ))
            ->end()
            ->end();
    }
}
