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

use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class WeeklyquizQuestionAdmin extends Admin implements ContainerAwareInterface
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

    public function generateUrl($name, array $parameters = array(), $absolute = false)
    {
        if (($name == 'list')) {
            return $this->container->get('router')->generate('admin_fitbase_weeklytask_weeklyquiz_list');
        }

        return parent::generateUrl($name, $parameters, $absolute);
    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('name', null, array(
                'label' => 'Name',
            ))
            ->add('quiz', null, array(
                'label' => 'Quiz',
            ))
            ->add('type', null, array(
                'label' => 'Type',
            ))
            ->add('description', null, array(
                'safe' => true,
                'label' => 'Beschreibung',
            ))
            ->end()
            ->with('Optionen', array('class' => 'col-md-6'))
            ->add('countPoint', null, array(
                'label' => 'Punkte',
            ))
            ->add('answers', null, array(
                'label' => 'Antworte',
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
            ->add('countPoint', null, array(
                'label' => 'Punkte',
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
            ->add('quiz', null, array(
                'label' => 'Quiz',
            ))
            ->add('countPoint', null, array(
                'label' => 'Punkte',
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $optionsQuiz = array(
            'read_only' => true,
        );

        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

        if (($quizId = $this->container->get('request')->get('quiz', null))) {
            if (($quiz = $repositoryWeeklyquiz->findOneById($quizId))) {
                $optionsQuiz['data'] = $quiz;
            }
        }

        $formMapper
            ->tab('General')
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
            ->add('type', 'choice', array(
                'required' => false,
                'label' => 'Type',
                'empty_value' => 'Wählen Sie eine Variante',
                'choices' => array(
                    'checkbox' => 'Mehrwahl',
                    'radiobutton' => 'Einzelwahl',
                ),
            ))
            ->end()
            ->with('Options', array('class' => 'col-md-6'))
            ->add('countPoint', 'integer', array('label' => 'Punkte'))
            ->end()
            ->with('Beschreibung', array('class' => 'col-md-12'))
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
            ->end()
            ->tab('Integration')
            ->with('Optionen', array('class' => 'col-md-6'))
            ->add('quiz', null, $optionsQuiz)
            ->end();
    }
}