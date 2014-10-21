<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class UserMedimouseForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'label' => "Email",
            'required' => true,
            'attr' => array(
                'class' => 'form-control'
            ),
        ))
            ->add('nameFirst', 'text', array(
                'label' => "Vorname",
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('nameLast', 'text', array(
                'label' => "Nachname",
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('bereich', new UserMedimouseBereichType())
            ->add('type', new UserMedimouseTypeType())
            ->add('extra', new UserMedimouseExtraType())
            ->add('save', 'submit', array(
                'label' => 'Benutzer anlegen',
                'attr' => array(
                    'class' => 'btn btn-success btn-lg'
                )
            ));

    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'medimouse';
    }
}