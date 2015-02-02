<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserRegistrationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actioncode', 'hidden')
            ->add('first_name', null, array(
                'label' => 'Vorname',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('last_name', null, array(
                'label' => 'Nachname',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email', null, array(
                'label' => 'Email',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('terms', 'checkbox', array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Anmelden',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserRegistration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'userregistration';
    }
}
