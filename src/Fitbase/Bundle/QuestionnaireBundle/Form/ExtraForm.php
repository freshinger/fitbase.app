<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExtraForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('au', 'checkbox', array(
                'required' => false,
                'label' => 'Augen-Entspannung',
            ))
            ->add('rs', 'checkbox', array(
                'required' => false,
                'label' => 'Hand-Arm-Prävention',
            ))
            ->add('th', 'checkbox', array(
                'required' => false,
                'label' => 'Thera-Band®',
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\QuestionnaireBundle\Entity\Extra',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'extra';
    }
}
