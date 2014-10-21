<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireQuestionForm extends AbstractType
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
            'data_class' => 'Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'questionnaire_question';
    }
}
