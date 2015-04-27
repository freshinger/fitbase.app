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
                'label' => 'Authentication key. Can not be empty. It ist just a random string for now',
            ))
            ->add('timestamp', 'text', array(
                'label' => 'Date of position as a unix timestamp',
            ))
            ->add('head', 'text', array(
                'label' => 'Head coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('shoulderCenter', 'text', array(
                'label' => 'Shoulder (center) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('shoulderLeft', 'text', array(
                'label' => 'Shoulder (left) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('shoulderRight', 'text', array(
                'label' => 'Shoulder (right) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('elbowLeft', 'text', array(
                'label' => 'Elbow (left) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('elbowRight', 'text', array(
                'label' => 'Elbow (right) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('handLeft', 'text', array(
                'label' => 'Hand (left) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('handRight', 'text', array(
                'label' => 'Hand (right) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('com', 'text', array(
                'label' => 'COM coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('spine', 'text', array(
                'label' => 'Spine coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('hipLeft', 'text', array(
                'label' => 'Hip (right) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('hipRight', 'text', array(
                'label' => 'Hip (right) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('kneeLeft', 'text', array(
                'label' => 'Knee (left) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('kneeRight', 'text', array(
                'label' => 'Knee (right) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('footLeft', 'text', array(
                'label' => 'Foot (left) coordinate x.xxx;y.yyy;z.zzz',
            ))
            ->add('footRight', 'text', array(
                'label' => 'Foot (right) coordinate x.xxx;y.yyy;z.zzz',
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

//{"user_state":{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3", "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3", "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3", "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3", "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":""}}
