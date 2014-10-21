<?php

namespace Fitbase\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CompanyColorType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'color'
            ),
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'company_color';
    }
}