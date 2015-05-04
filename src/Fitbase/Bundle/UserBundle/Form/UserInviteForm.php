<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class UserInviteForm extends AbstractType
{
    /**
     * Build form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'required' => false,
            ))
            ->add('company', 'entity', array(
                'required' => false,
                'class' => 'FitbaseCompanyBundle:Company',
            ))
            ->add('text', 'textarea', array(
                'required' => false,
            ));

    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'user_invite';
    }
}