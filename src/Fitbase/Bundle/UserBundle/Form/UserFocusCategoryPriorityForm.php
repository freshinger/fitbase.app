<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusCategoryPriorityForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priority', 'hidden', array(
                'label' => false,
                'attr' => array(
                    'class' => 'priority'
                )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => true,
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserFocusCategory',
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'user_focus_priority_category';
    }
}