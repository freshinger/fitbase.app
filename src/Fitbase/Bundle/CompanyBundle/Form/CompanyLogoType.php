<?php

namespace Fitbase\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CompanyLogoType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Logo',
            'attr' => array(
                'class' => ''
            ),
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'company_logo';
    }
}