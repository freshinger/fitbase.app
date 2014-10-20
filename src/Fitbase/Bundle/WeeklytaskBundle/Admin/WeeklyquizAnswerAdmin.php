<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class WeeklyquizAnswerAdmin extends Admin implements ContainerAwareInterface
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
            ->add('Name', null, array(
                'label' => 'Name',
            ))
            ->add('quiz', null, array(
                'label' => 'Quiz',
            ))
            ->add('question', null, array(
                'label' => 'Question',
            ))
            ->add('description', null, array(
                'safe' => true,
                'label' => 'Beschreibung',
            ))
            ->add('correct', null, array(
                'label' => 'Is richtig',
            ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array(
                'label' => 'Name',
            ))
            ->add('quiz', null, array(
                'label' => 'Quiz',
            ))
            ->add('question', null, array(
                'label' => 'Question',
            ))
            ->add('correct', null, array(
                'label' => 'Is richtig',
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
            ->add('name', null, array(
                'label' => 'Name',
            ))
            ->add('question', null, array(
                'label' => 'Question',
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name', null, array(
                'label' => 'Name',
            ))
            ->add('question', null, array(
                'label' => 'Question',
            ))
            ->add('description', 'sonata_formatter_type', array(
                'label' => 'Beschreibung',
                'event_dispatcher' => $this->container->get('event_dispatcher'),
                'format_field' => 'format',
                'source_field' => 'description',
                'source_field_options' => array(
                    'attr' => array('class' => 'span10', 'rows' => 20)
                ),
                'listener' => true,
                'target_field' => 'content'
            ))
            ->add('correct', null, array(
                'label' => 'Is richtig',
            ))
            ->end();
    }
}