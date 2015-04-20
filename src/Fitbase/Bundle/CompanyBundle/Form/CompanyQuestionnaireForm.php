<?php

namespace Fitbase\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CompanyQuestionnaireForm extends AbstractType
{
    protected $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionnaire', 'entity', array(
                'label' => 'Fragebogen',
                'empty_value' => false,
                'class' => 'Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire',
                'query_builder' => function ($repository) {
                    $queryBuilder = $repository->createQueryBuilder('CompanyQuestionnaire');
                    $queryBuilder->where($queryBuilder->expr()->eq('CompanyQuestionnaire.company', ':company'));
                    $queryBuilder->setParameter(':company', $this->company->getId());
                    return $queryBuilder;
                }
            ))
            ->add('date', 'sonata_type_datetime_picker', array(
                'label' => 'Datum',
                'date_format' => 'dd.MM.yyyy, HH:mm'
            ))
            ->add('save', 'submit', array(
                'label' => 'Umfrage anlegen',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'company_questionnaire';
    }
}