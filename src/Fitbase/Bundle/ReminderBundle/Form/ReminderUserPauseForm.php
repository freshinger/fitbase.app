<?php

namespace Fitbase\Bundle\ReminderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ReminderUserPauseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pause', 'choice', array(
                'required' => false,
                'label' => 'Wie lange möchten Sie fitbase pausieren?',
                'choices' => array(
                    '1' => '1 Woche',
                    '2' => '2 Wochen',
                    '3' => '3 Wochen',
                    '4' => '4 Wochen',
                ),
                'empty_value' => 'Bitte wählen',
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\ReminderBundle\Entity\ReminderUser'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'reminder_pause';
    }
}