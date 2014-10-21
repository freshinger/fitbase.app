<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserMedimouseTypeType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Schritt 2 – Rückentyp',
            'expanded' => true,
            'choices' => array(
                'FT' => 'Fester Typ',
                'ST' => 'Standard',
                'LT' => 'Loser Typ'
            ),
            'data' => 'ST',
            'required' => true,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'medimouse_type';
    }
}