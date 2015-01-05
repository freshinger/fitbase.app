<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class QuestionnaireQuestionAdmin extends Admin implements ContainerAwareInterface
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
            ->add('questionnaire')
            ->add('type')
            ->add('description')
            ->add('answers', null, array(
                'label' => 'Antworte',
                'template' => 'FitbaseQuestionnaireBundle:Admin:question_show_answer.html.twig'
            ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('questionnaire')
            ->add('type')
            ->add('description')
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
            ->add('questionnaire')
            ->add('type')
            ->add('description');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', array('class' => 'col-md-6'))
            ->add('name')
            ->add('type', 'choice', array(
                'required' => false,
                'label' => 'Type',
                'empty_value' => false,
                'choices' => array(
                    'checkbox' => 'Mehrwahl',
                    'radiobutton' => 'Einzelwahl',
                    'slider' => 'Slider',
                    'selectbox' => 'Selectbox',
                    'text' => 'Text',
                ),
            ))
            ->add('description', 'sonata_formatter_type', array(
                'required' => false,
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
            ->end()
            ->with('Integration', array('class' => 'col-md-6'))
            ->add('questionnaire')
            ->add('categories')
            ->end();

//        if (($user = $this->getRoot()->getSubject())) {
//            if (($focus = $user->getFocus())) {

        $formMapper
            ->with('Answers', array('class' => 'col-md-6'))
            ->add('answers')
            ->end();
    }
}