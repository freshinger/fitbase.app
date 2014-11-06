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

class ReminderUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sendWeeklytask', 'checkbox', array(
                'required' => false,
                'label' => 'Die Wochenaufgaben versenden',
            ))
            ->add('sendWeeklyquiz', 'checkbox', array(
                'required' => false,
                'label' => 'Die Wochenquizze versenden',
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
            'data_class' => 'Fitbase\Bundle\ReminderBundle\Entity\ReminderUser'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'reminder';
    }
} 