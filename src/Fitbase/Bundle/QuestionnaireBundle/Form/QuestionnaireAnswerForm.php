<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireAnswerForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Name',
                'attr' => array(
                    'placeholder' => 'Name',
                ),
            ))
            ->add('countPointHealth', 'text', array(
                'required' => false,
                'label' => 'Punkte für den Gesundheitszustand',
                'attr' => array(
                    'placeholder' => 'Punkte für den Gesundheitszustand',
                ),
            ))
            ->add('countPointStrain', 'text', array(
                'required' => false,
                'label' => 'Punkte für die Belastung',
                'attr' => array(
                    'placeholder' => 'Punkte für die Belastung',
                ),
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Beschreibung',
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
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
            'data_class' => 'Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'questionnaire_answer';
    }
}
