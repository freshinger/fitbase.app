<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PasswordForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('current', 'text', array(
                'label' => 'Bestehendes Passwort',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('password', 'repeated', array(
                'invalid_message' => 'Bitte geben Sie in beide Felder das gleiche Passwort ein.',
                'first_options' => array(
                    'label' => 'Neues Passwort',
                    'attr' => array(
                        'class' => 'form-control'
                    ),
                ),
                'second_options' => array(
                    'label' => 'Neues Passwort wiederholen',
                    'attr' => array(
                        'class' => 'form-control'
                    ),
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserPassword'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'password';
    }
}
