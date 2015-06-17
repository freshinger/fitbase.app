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


class QuestionnaireUserAdmin extends Admin implements ContainerAwareInterface
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
            ->add('user')
            ->add('questionnaire')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user')
            ->add('questionnaire')
            ->add('date')
            ->add('done', 'boolean')
            ->add('doneDate')
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
            ->add('user')
            ->add('questionnaire');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('user');

        $formMapper->add('questionnaire');
        if (($questionnaireUser = $this->getRoot()->getSubject()) and
            ($user = $questionnaireUser->getUser()) and
            ($company = $user->getCompany())
        ) {
            $formMapper->add('questionnaire', null, array(
                'query_builder' => function ($repository) use ($company) {
                    $queryBuilder = $repository->createQueryBuilder('UserActioncode');
                    $queryBuilder->where($queryBuilder->expr()->eq('UserActioncode.company', ':company'));
                    $queryBuilder->setParameter(':company', $company->getId());

                    return $queryBuilder;
                }
            ));
        }

        $formMapper->add('date', 'sonata_type_datetime_picker', array('date_format' => 'dd.MM.yyyy, HH:mm'))
            ->add('pause', null, array(
                'required' => false,
            ))
            ->end();
    }
}