<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklyquizForm extends AbstractType
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
            ))
            ->add('description', 'tinymce', array(
                'label' => 'Description',
            ))
            ->add('countPoint', 'integer', array(
                'label' => 'Punkte',
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
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
            'data_class' => 'Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask_quiz';
    }
}
