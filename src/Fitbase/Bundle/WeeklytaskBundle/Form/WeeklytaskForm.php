<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklytaskForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Name',
                'attr' => array(
                    'placeholder' => 'Name'
                )
            ))
            ->add('countPoint', 'text', array(
                'label' => 'Anzahl der Points',
                'attr' => array(
                    'placeholder' => 'Anzahl der Points'
                )
            ))
            ->add('weekId', 'text', array(
                'label' => 'Woche',
                'attr' => array(
                    'placeholder' => 'Woche'
                )
            ))
//            ->add('quizId', 'quiz', array(
//                'required' => false,
//                'label' => 'Quiz',
//                'attr' => array(
//                    'placeholder' => 'Quiz'
//                )
//            ))
            ->add('content', 'textarea', array(
                'label' => 'Description',
                'attr' => array(
                    'placeholder' => 'Beschreibung'
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Anlegen',
                'attr' => array(
                    'class' => 'button button-primary',
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask';
    }
}
