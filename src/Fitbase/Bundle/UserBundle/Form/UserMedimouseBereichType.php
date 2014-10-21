<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserMedimouseBereichType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Schritt 1 – Problembereich',
            'expanded' => true,
            'choices' => array(
                'SN' => 'Oberer Ruecken',
                'MR' => 'Mittlere Ruecken',
                'UR' => 'Unterer Ruecken'
            ),
            'data' => 'SN',
            'required' => true,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'medimouse_bereich';
    }
}