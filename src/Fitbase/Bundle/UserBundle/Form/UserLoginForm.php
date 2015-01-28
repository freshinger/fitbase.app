<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserLoginForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', null, array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('password', null, array(
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
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserLogin'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_login';
    }
}
