<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserActioncodeForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', null, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ))
            ->add('save', 'submit', array(
                'label' => 'Zugangscode einlösen',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserActioncode',
            'validation_groups' => array('registration'),
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'useractioncode';
    }
}
