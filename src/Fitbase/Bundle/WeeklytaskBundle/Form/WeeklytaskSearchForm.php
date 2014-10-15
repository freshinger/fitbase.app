<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklytaskSearchForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', 'text', array(
                'label' => 'Such-muster',
                'attr' => array(
                    'placeholder' => 'Geben Sie Such-Muster ein...',
                    'style' => 'width: 65%; vertical-align: middle;',
                )
            ))
            ->add('order', 'choice', array(
                'required' => false,
                'label' => 'Order',
                'empty_value' => 'Ohne Sortierung',
                'choices' => array(
                    'name' => 'Name',
                    'category' => 'Category',
                    'weekId' => 'Week',
                    'postId' => 'Post',
                    'quizId' => 'Quiz',
                ),
                'attr' => array(
                    'style' => 'float: none',
                )
            ))
            ->add('by', 'choice', array(
                'required' => false,
                'label' => 'By',
                'empty_value' => 'Ohne Sortierung',
                'choices' => array(
                    'asc' => 'Aufsteigend',
                    'desc' => 'Absteigend',
                ),
                'attr' => array(
                    'style' => 'float: none',
                )
            ))->add('save', 'submit', array(
                'label' => 'Suchen',
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
            'data_class' => 'Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask_search';
    }
}
