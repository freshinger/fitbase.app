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

use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserActioncodeAdmin extends Admin implements ContainerAwareInterface
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
    public function prePersist($object)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUserActioncode = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');

        do {

            $code = $this->container->get('codegenerator')->code(10);
            $object->setCode("{$object->getPrefix()}{$code}");

        } while ($repositoryUserActioncode->findOneByCode($object->getCode()));

        $object->setDate($this->container->get('datetime')->getDateTime('now'));
    }


    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        if (($count = $object->getCount())) {
            for ($i = 1; $i < $count; $i++) {

                $entity = new UserActioncode();
                $entity->setPrefix($object->getPrefix());
                $entity->setCompany($object->getCompany());
                $entity->setDuration($object->getDuration());
                $entity->setDate($object->getDate());
                $entity->setCategories($object->getCategories());
                $entity->setCount(0);

                $this->prePersist($entity);

                $this->container->get('entity_manager')->persist($entity);
                $this->container->get('entity_manager')->flush($entity);

                $this->postPersist($entity);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('code')
            ->add('user')
            ->add('company')
            ->add('duration')
            ->add('date')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('code')
            ->add('company')
            ->add('user')
            ->add('categories')
            ->add('duration')
            ->add('processed')
            ->add('processedDate', 'date')
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
            ->add('code')
            ->add('company')
            ->add('duration')
            ->add('date');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        if (($actioncode = $this->getRoot()->getSubject())) {
            if (!$actioncode->getId()) {
                $formMapper
                    ->with('Generation', array('class' => 'col-md-6'))
                    ->add('prefix', 'text')
                    ->add('count', 'text')
                    ->end();
            }
        }

        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('company', null, array(
                'required' => true,
            ))
            ->add('duration', null, array(
                'required' => true,
            ))
            ->add('categories', null, array(
                'required' => true,
                'query_builder' => function ($repository) {
                    $queryBuilder = $repository->createQueryBuilder('Category');
                    $queryBuilder->where($queryBuilder->expr()->isNull('Category.parent'));
                    return $queryBuilder;
                }
            ))
            ->end();
    }
}
