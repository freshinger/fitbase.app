<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 3:06 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReminderUserItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', 'choice', array(
                'required' => false,
                'label' => 'Tag',
                'empty_value' => 'Tag der Woche',
                'choices' => array(
                    '1' => 'Montag',
                    '2' => 'Dienstag',
                    '3' => 'Mittwoch',
                    '4' => 'Donnerstag',
                    '5' => 'Freitag',
                ),
            ))
            ->add('time', 'time', array(
                'empty_value' => array('hour' => 'hh', 'minute' => 'mm'),
                'required' => false,
                'label' => 'Stunde',
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'reminder_item';
    }
} 