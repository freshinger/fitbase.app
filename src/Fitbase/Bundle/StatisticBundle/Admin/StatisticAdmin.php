<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\StatisticBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class StatisticAdmin extends Admin implements ContainerAwareInterface
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
            ->add('countLogin')
            ->add('loggedAt')
            ->add('userAgent')
            ->add('countExercise')
            ->with('Wochenaufgaben', array('class' => 'col-md-6'))
            ->end()
            ->add('countWeeklyTask')
            ->add('countWeeklyTaskProcessed')
            ->with('Quizze', array('class' => 'col-md-6'))
            ->end()
            ->add('countWeeklyQuiz')
            ->add('countWeeklyQuizProcessed')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('countLogin')
            ->add('loggedAt')
            ->add('userAgent')
            ->add('countExercise')
            ->add('countWeeklyTask')
            ->add('countWeeklyTaskProcessed')
            ->add('countWeeklyQuiz')
            ->add('countWeeklyQuizProcessed')
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
            ->add('countLogin')
            ->add('loggedAt')
            ->add('userAgent')
            ->add('countExercise')
            ->add('countWeeklyTask')
            ->add('countWeeklyTaskProcessed')
            ->add('countWeeklyQuiz')
            ->add('countWeeklyQuizProcessed');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('countLogin')
            ->add('loggedAt')
            ->add('userAgent')
            ->add('countExercise')
            ->with('Wochenaufgaben', array('class' => 'col-md-6'))
            ->end()
            ->add('countWeeklyTask')
            ->add('countWeeklyTaskProcessed')
            ->with('Quizze', array('class' => 'col-md-6'))
            ->end()
            ->add('countWeeklyQuiz')
            ->add('countWeeklyQuizProcessed')
            ->end();
    }
}