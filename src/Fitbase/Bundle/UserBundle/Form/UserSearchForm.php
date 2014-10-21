<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', 'text', array(
                'required' => false,
                'label' => 'Such - Muster',
                'attr' => array(
                    'placeholder' => 'Geben Sie Such-Muster ein...',
                    'style' => 'width: 65%; vertical-align: middle;',
                )
            ))
            ->add('order', 'choice', array(
                'required' => false,
                'label' => 'Order',
                'empty_value' => 'Ohne Sortierung',
                'choices' => array(
                    'id' => 'Id',
                    'videos' => 'Videos',
                    'logins' => 'Logins',
                    'weeklytasks' => 'Wochenaufgaben',
                    'registeredAt' => 'Registriert',
                    'loggedAt' => 'Letzter login',
                ),
                'attr' => array(
                    'style' => 'float: none',
                )
            ))
            ->add('by', 'choice', array(
                'required' => false,
                'label' => 'By',
                'empty_value' => 'Ohne Sortierung',
                'choices' => array(
                    'asc' => 'Aufsteigend',
                    'desc' => 'Absteigend',
                ),
                'attr' => array(
                    'style' => 'float: none',
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Suchen',
                'attr' => array(
                    'class' => 'button action',
                ),
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'user_search';
    }
}