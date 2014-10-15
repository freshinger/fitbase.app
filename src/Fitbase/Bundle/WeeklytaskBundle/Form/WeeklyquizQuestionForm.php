<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklyquizQuestionForm extends AbstractType
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
            ))
            ->add('type', 'choice', array(
                'required' => false,
                'label' => 'Type',
                'empty_value' => 'Wählen Sie eine Variante',
                'choices' => array(
                    'checkbox' => 'Mehrwahl',
                    'radiobutton' => 'Einzelwahl',
                ),
            ))
            ->add('description', 'textarea', array(
                'label' => 'Description',
            ))->add('countPoint', 'integer', array(
                'label' => 'Punkte',
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
            'data_class' => 'Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask_question';
    }
}
