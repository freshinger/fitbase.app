<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\CompanyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CompanyAdmin extends Admin implements ContainerAwareInterface
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
     * Pre create action
     *
     * @param mixed $object
     * @return mixed|void
     */
    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    /**
     * On object update action
     *
     * @param mixed $object
     * @return mixed|void
     */
    public function preUpdate($object)
    {

    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
            ->add('slug')
            ->add('site')
            ->add('description')
            ->end()
            ->with('Logo', array('class' => 'col-md-6'))
            ->add('logo')
            ->add('logoWidth')
            ->add('logoHeight')
            ->end()
            ->with('Style', array('class' => 'col-md-6'))
            ->add('colorHeader')
            ->add('colorFooter')
            ->add('colorBackground')
            ->end()
            ->with('Extra', array('class' => 'col-md-6'))
            ->add('questionnaire')
            ->add('gamification')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('site')
            ->add('name')
            ->add('parent')
            ->add('usersCount', null, ['label' => 'Benutzer'])
            ->add('questionnaire', null, ['label' => 'Bedarfsermittlung'])
            ->add('categories')
            ->add('gamification')
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
            ->add('site');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('General')
            ->with('General', array('class' => 'col-md-4'))
            ->add('name', null, array('required' => true))
            ->Add('slug');

        $formMapper->add('parent', null, array('required' => false));
        if (($company = $this->getRoot()->getSubject())) {
            if (!($parent = $company->getParent())) {
                $formMapper->add('site', null, array('required' => true));
            }
        }

        $formMapper->add('description', null, array('required' => false));
        $formMapper->end();

        if (($company = $this->getRoot()->getSubject())) {
            $formMapper->with('Bedarfsermittlung', array('class' => 'col-md-4'))
                ->add('questionnaire', null, array(
                    'query_builder' => function ($repository) use ($company) {
                        $queryBuilder = $repository->createQueryBuilder('CompanyQuestionnaire');
                        $queryBuilder->where($queryBuilder->expr()->eq('CompanyQuestionnaire.company', ':company'));
                        $queryBuilder->setParameter(':company', $company->getId());

                        return $queryBuilder;
                    }
                ))
                ->end();
        }
        $formMapper
            ->with('Gamification', array('class' => 'col-md-4'))
            ->add('gamification', null, array('required' => false), array(
                'link_parameters' => array('context' => 'company')
            ))
//                ->add('attributes', 'sonata_type_model_list', array('required' => false), array(
//                    'link_parameters' => array('context' => 'company')
//                ))
            ->end();

        $formMapper->end();

        $formMapper
            ->tab('Statistic')
            ->with('Limits', array('class' => 'col-md-4'))
            ->add('userLimit', null, array(
                'label' => 'Minimale Anzahl der Nutzer um die Statistic anzuzeigen'
            ))
            ->end()
            ->end();

        $formMapper
            ->tab('Style')
            ->with('Logo', array('class' => 'col-md-4'))
            ->add('image', 'sonata_type_model_list', array('required' => false), array('link_parameters' => array('context' => 'company')))
            ->add('css', 'textarea', array('required' => false))
            ->end()
//            ->with('Header/Footer', array('class' => 'col-md-4'))
//            ->add('header', 'genemu_jquerycolor', array('required' => false))
//            ->end()
            ->with('Farbe', array('class' => 'col-md-4'))
//            ->add('background2', 'genemu_jquerycolor', array(
//                'required' => false, 'label' => 'Global background'
//            ))
            ->add('background1', 'genemu_jquerycolor', array(
                'required' => false,
                'label' => 'Eigene Farbe'
            ))
            ->end()
            ->end();
    }
}