<?php

namespace Fitbase\Bundle\ReminderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserWizardForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('save', 'submit', array(
                'label' => 'Weiter',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'ReminderUserWizard';
    }
}