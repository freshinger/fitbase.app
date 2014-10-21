<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserMedimouseExtraType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Schritt 3 – Zusatzoptionen',
            'expanded' => true,
            'multiple' => true,
            'choices' => array(
                'AU' => 'Augen',
                'RS' => 'RSI',
                'TH' => 'Thera Band'
            ),
            'required' => false,
            'attr' => array(
                'class' => ''
            ),
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'medimouse_extra';
    }
}