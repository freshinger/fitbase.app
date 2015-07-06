<?php

namespace Fitbase\Bundle\BudniBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationUserForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array(
                'label' => 'Vorname',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('lastName', null, array(
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
            'data_class' => 'Fitbase\Bundle\BudniBundle\Model\RegistrationUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'registration';
    }
}
