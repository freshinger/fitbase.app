<?php

namespace Wellbeing\Bundle\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wellbeing\Bundle\ApiBundle\Form\DataTransformer\UserStateDataTransformer;

class UserState extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new UserStateDataTransformer());

        $builder
            ->add('authKey', 'text', array(
                'label' => 'Authentication key',
            ))
            ->add('timestamp', 'text', array(
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
            'data_class' => 'Wellbeing\Bundle\ApiBundle\Model\UserState'
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
