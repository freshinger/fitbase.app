<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FocusForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('focus', 'choice', array(
                'label' => null,
                'choices' => array(
                    'sn' => ' Schulter-Nacken',
                    'ub' => ' Mittlerer Rücken ',
                    'lb' => 'Unterer Rücken ',
                ),
                'expanded' => true,
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\QuestionnaireBundle\Entity\Focus',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'focus';
    }
}
