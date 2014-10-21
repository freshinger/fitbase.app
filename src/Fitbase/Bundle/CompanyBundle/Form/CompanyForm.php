<?php

namespace Fitbase\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('site', 'url', array(
                'required' => false,
            ))
            ->add('logo', new CompanyLogoType())
            ->add('logoWidth', 'integer', array(
                'required' => false,
            ))
            ->add('logoHeight', 'integer', array(
                'required' => false,
            ))
            ->add('colorHeader', new CompanyColorType())
            ->add('colorFooter', new CompanyColorType())
            ->add('colorBackground', new CompanyColorType())
            ->add('gamification', 'choice', array(
                'label' => 'Gamification-Funktion für die Mitglieder',
                'choices' => array(
                    0 => 'Deaktivieren',
                    1 => 'Aktivieren',
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Unternehmen speichern',
                'attr' => array(
                    'class' => 'button button-primary'
                ),
            ));
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
            'data_class' => 'Fitbase\Bundle\CompanyBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'company';
    }
}
