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


class GamificationSettingsAdmin extends Admin implements ContainerAwareInterface
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('General')
                ->with('General', array('class' => 'col-md-6'))
                    ->add('name', 'text')
                ->end()
            ->end()
            ->tab('Avatars')
                ->with('General', array('class' => 'col-md-11'))
                    ->add('settingsHasAvatar', 'sonata_type_collection', array(
                            'cascade_validation' => true,
                        ), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                            'link_parameters' => array('context' => 'company'),
                        )
                    )
                ->end()
            ->end()
            ->tab('Trees')
                ->with('General', array('class' => 'col-md-11'))
                    ->add('settingsHasTree', 'sonata_type_collection', array(
                            'cascade_validation' => true,
                        ), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                            'link_parameters' => array('context' => 'company'),
                        ))
                ->end()
            ->end()
            ->tab('Background')
                ->with('General', array('class' => 'col-md-11'))
                    ->add('settingsHasBackground', 'sonata_type_collection', array(
                            'cascade_validation' => true,
                        ), array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                            'link_parameters' => array('context' => 'company'),
                        ))
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('settingsHasAvatar', null, array(
                'label' => 'Avatare'
            ))
            ->add('settingsHasTree', null, array(
                'label' => 'Bäume'
            ))
            ->add('settingsHasBackground', null, array(
                'label' => 'Hintergründe'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($settings)
    {
        $settings->setSettingsHasAvatar($settings->getSettingsHasAvatar());
        $settings->setSettingsHasTree($settings->getSettingsHasTree());
        $settings->setSettingsHasBackground($settings->getSettingsHasBackground());
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($settings)
    {
        $settings->setSettingsHasAvatar($settings->getSettingsHasAvatar());
        $settings->setSettingsHasTree($settings->getSettingsHasTree());
        $settings->setSettingsHasBackground($settings->getSettingsHasBackground());
    }
}