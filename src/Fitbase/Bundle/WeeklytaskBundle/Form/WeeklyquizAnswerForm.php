<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklyquizAnswerForm extends AbstractType
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
            ->add('correct', 'choice', array(
                'required' => false,
                'label' => 'Antwort is richtig',
                'empty_value' => 'Nicht definiert',
                'choices' => array(
                    0 => 'Falsch',
                    1 => 'Richtig',
                ),
                'attr' => array(
                    'style' => 'float: none',
                )
            ))
            ->add('description', 'textarea', array(
                'label' => 'Description',
            ))->add('save', 'submit', array(
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
            'data_class' => 'Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask_answer';
    }
}
