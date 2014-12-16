<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusCategoriesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('parent')
            ->add('priority');

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserFocusCategory'
        ));
    }


    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'user_focus_category';
    }
}