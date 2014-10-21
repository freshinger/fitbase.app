<?php

namespace Fitbase\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Fitbase\Bundle\CompanyBundle\Form\CompanyType;

class CompanyUserForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company', new CompanyType());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'form-table'
            ),
            'required' => false,
            'data_class' => 'Fitbase\Bundle\CompanyBundle\Entity\CompanyUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'company_user';
    }
}
