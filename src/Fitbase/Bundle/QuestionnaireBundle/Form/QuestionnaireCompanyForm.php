<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireCompanyForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionnaire', 'entity', array(
                'label' => 'Fragebogen',
                'property' => 'name',
                'empty_value' => 'Kein Fragebogen',
                'class' => 'Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire',
            ))
            ->add('intervalWeek', 'integer', array(
                'required' => false,
                'label' => 'Interval',
            ))
            ->add('save', 'submit', array(
                'label' => 'Anlegen',
                'attr' => array(
                    'class' => 'button button-primary',
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
        return 'questionnaire_company';
    }
}
