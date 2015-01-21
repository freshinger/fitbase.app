<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class ImportActioncodeForm extends AbstractType implements ContainerAwareInterface
{

    /**
     * Store container here
     * @var
     */
    protected $container;

    /**
     * Set container to class
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * Build form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', 'entity', array(
                'class' => 'FitbaseCompanyBundle:Company',
            ))
            ->add('questionnaire', 'entity', array(
                'class' => 'FitbaseQuestionnaireBundle:Questionnaire',
            ))
            ->add('categories', 'entity', array(
                'multiple' => true,
                'class' => 'ApplicationSonataClassificationBundle:Category',
                'query_builder' => function (EntityRepository $repository) {
                    $queryBuilder = $repository->createQueryBuilder('Category');
                    return $queryBuilder->where($queryBuilder->expr()->isNull('Category.parent'))
                        ->orderBy('Category.position', 'ASC');
                },
            ))
            ->add('duration', 'integer', array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('codes', 'textarea', array(
                'attr' => array('class' => 'form-control', 'rows' => 20)
            ))
            ->add('save', 'submit', array(
                'label' => 'Codes importieren',
                'attr' => array(
                    'class' => 'btn btn-success',
                ),
            ));

    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'import_code';
    }
}