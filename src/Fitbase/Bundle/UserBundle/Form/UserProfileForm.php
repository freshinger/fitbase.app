<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel', 'text', array(
                'required' => false,
                'label' => 'Titel (optional)',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('gender', 'choice', array(
                'required' => false,
                'label' => 'Anrede',
                'choices' => array(
                    'f' => 'Frau',
                    'm' => 'Herr',
                ),
                'empty_value' => 'Bitte wählen',
            ))
            ->add('firstname', 'text', array(
                'required' => false,
                'label' => 'Vorname',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('lastname', 'text', array(
                'required' => false,
                'label' => 'Nachname',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'E-Mail-Adresse',
                'attr' => array(
                    'class' => 'form-control',
                ),
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
            'data_class' => 'Application\Sonata\UserBundle\Entity\User'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'fitbase_user_profile';
    }
}