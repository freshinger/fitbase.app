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
                'label' => 'Head coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('shoulderCenter', 'text', array(
                'label' => 'Shoulder coordinate x.xxx;y.yyy;z.zzz (center)',
            ))
            ->add('shoulderLeft', 'text', array(
                'label' => 'Shoulder coordinate x.xxx;y.yyy;z.zzz (left)',
            ))
            ->add('shoulderRight', 'text', array(
                'label' => 'Shoulder coordinate x.xxx;y.yyy;z.zzz (right)',
            ))
            ->add('elbowLeft', 'text', array(
                'label' => 'Elbow coordinate x.xxx;y.yyy;z.zzz (left)',
            ))
            ->add('elbowRight', 'text', array(
                'label' => 'Elbow coordinate x.xxx;y.yyy;z.zzz (right)',
            ))
            ->add('handLeft', 'text', array(
                'label' => 'Hand coordinate x.xxx;y.yyy;z.zzz (left)',
            ))
            ->add('handRight', 'text', array(
                'label' => 'Hand coordinate x.xxx;y.yyy;z.zzz (right)',
            ))
            ->add('com', 'text', array(
                'label' => 'COM coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('spine', 'text', array(
                'label' => 'Spine coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('hipLeft', 'text', array(
                'label' => 'Hip coordinate x.xxx;y.yyy;z.zzz (right)',
            ))
            ->add('hipRight', 'text', array(
                'label' => 'Hip coordinate x.xxx;y.yyy;z.zzz (right)',
            ))
            ->add('kneeLeft', 'text', array(
                'label' => 'Knee coordinate x.xxx;y.yyy;z.zzz (left)',
            ))
            ->add('kneeRight', 'text', array(
                'label' => 'Knee coordinate x.xxx;y.yyy;z.zzz (right)',
            ))
            ->add('footLeft', 'text', array(
                'label' => 'Foot coordinate x.xxx;y.yyy;z.zzz (left)',
            ))
            ->add('footRight', 'text', array(
                'label' => 'Foot coordinate x.xxx;y.yyy;z.zzz (right)',
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
