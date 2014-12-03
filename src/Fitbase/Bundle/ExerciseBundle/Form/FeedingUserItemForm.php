<?php

namespace Fitbase\Bundle\ExerciseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeedingUserItemForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', null, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('group', null, array(
                'disabled' => true,
                'empty_value' => false,
                'attr' => array(
                    'class' => 'form-control'
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\ExerciseBundle\Entity\FeedingUserItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'feedinguseritem';
    }
}
