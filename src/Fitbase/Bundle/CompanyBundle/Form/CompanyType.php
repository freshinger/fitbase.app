<?php

namespace Fitbase\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CompanyType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Unternehmen',
            'property' => 'name',
            'empty_value' => 'Kein Unternehmen',
            'class' => 'Fitbase\Bundle\CompanyBundle\Entity\Company',
        ));
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'field_company';
    }
}