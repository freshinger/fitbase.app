<?php

namespace Wellbeing\Bundle\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserState extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authkey', 'text', array(
                'label' => 'Authentication key',
            ))
            ->add('timestamp', 'datetime', array(
                'label' => 'Date of position as a Unix Timestamp',
            ))
            ->add('head', 'text', array(
                'label' => 'Head coordinate X;Y;Z',
            ))
            ->add('shoulderCenter', 'text', array(
                'label' => 'Shoulder coordinate X;Y;Z (center)',
            ))
            ->add('shoulderLeft', 'text', array(
                'label' => 'Shoulder coordinate X;Y;Z (left)',
            ))
            ->add('shoulderRight', 'text', array(
                'label' => 'Shoulder coordinate X;Y;Z (right)',
            ))
            ->add('elbowLeft', 'text', array(
                'label' => 'Elbow coordinate X;Y;Z (left)',
            ))
            ->add('elbowRight', 'text', array(
                'label' => 'Elbow coordinate X;Y;Z (right)',

            ))
            ->add('handLeft', 'text', array(
                'label' => 'Hand coordinate X;Y;Z (left)',
            ))
            ->add('handRight', 'text', array(
                'label' => 'Hand coordinate X;Y;Z (right)',
            ))
            ->add('com', 'text', array(
                'label' => 'COM coordinate X;Y;Z',
            ))
            ->add('spine', 'text', array(
                'label' => 'Spine coordinate X;Y;Z',
            ))
            ->add('hipLeft', 'text', array(
                'label' => 'Hip coordinate X;Y;Z (right)',
            ))
            ->add('hipRight', 'text', array(
                'label' => 'Hip coordinate X;Y;Z (right)',
            ))
            ->add('kneeLeft', 'text', array(
                'label' => 'Knee coordinate X;Y;Z (left)',
            ))
            ->add('kneeRight', 'text', array(
                'label' => 'Knee coordinate X;Y;Z (right)',
            ))
            ->add('footLeft', 'text', array(
                'label' => 'Foot coordinate X;Y;Z (left)',
            ))
            ->add('footRight', 'text', array(
                'label' => 'Foot coordinate X;Y;Z (right)',
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_state';
    }
}
