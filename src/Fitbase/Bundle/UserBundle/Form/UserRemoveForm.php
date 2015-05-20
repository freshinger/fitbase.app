<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserRemoveForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accept', 'checkbox', array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Profil löschen',
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
        return 'remove_profile';
    }
}