<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserPauseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pause', 'choice', array(
                'required' => false,
                'label' => 'Wie lange möchten Sie die Online-Rückenschule pausieren?',
                'choices' => array(
                    '1' => '1 Woche',
                    '2' => '2 Wochen',
                    '3' => '3 Wochen',
                    '4' => '4 Wochen',
                ),
                'empty_value' => 'Bitte wählen',
                'attr' => array(
                    'class' => 'form-control',
                )
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
            'csrf_protection' => false,
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'pause';
    }
}