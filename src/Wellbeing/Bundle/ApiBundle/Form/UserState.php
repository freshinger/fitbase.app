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
        $builder
            ->add('authKey', 'text', ['label' => 'Authentication key. Can not be empty. It ist just a random string for now',])
            ->add('timestamp', 'text', ['label' => 'Date of position as a unix timestamp',])
            ->add('ticketType', 'text', ['label' => 'Must be “T1/T2/T3”',])
            ->add('head', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('shoulderCenter', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('shoulderLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('shoulderRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('elbowLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('elbowRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('handLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('handRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('spineMid', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('leanAmount', 'text', ['label' => 'Integer coordinates between -45° and 45° like X;Y. X corresponds to left/right lean angle and Y corresponds to forward/back lean angle',])
            ->add('headRotation', 'text', ['label' => 'Integer coordinates like X;Y;Z (denoting the head rotation in degrees for pitch, roll and yaw)',])
            ->add('neck', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('wristLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('wristRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('thumbLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('thumbRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('handTipLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('handTipRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('spineBase', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('hipLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('hipRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('kneeLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('kneeRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('ankleLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('ankleRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('footLeft', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('footRight', 'text', ['label' => 'Coordinates like x.xxx;y.yyy;z.zzz',])
            ->add('leftHandState', 'text', ['label' => '-1: unknown; 0: closed; 1:open; 2: lasso',])
            ->add('rightHandState', 'text', ['label' => '-1: unknown; 0: closed; 1:open; 2: lasso',])
            ->add('jawOpen', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lipPucker', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('jawSlideRight', 'text', ['label' => 'Coordinates between -1 and 1',])
            ->add('lipStretcherRight', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lipStretcherLeft', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lipCornerPullerLeft', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lipCornerPullerRight', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lipCornerDepressorLeft', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lipCornerDepressorRight', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('leftCheekPuff', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('rightCheekPuff', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('leftEyeClosed', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('rightEyeClosed', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('rightEyeBrowLowerer', 'text', ['label' => 'Coordinates between -1 and 1',])
            ->add('leftEyeBrowLowerer', 'text', ['label' => 'Coordinates between -1 and 1',])
            ->add('lowerLipDepressorLeft', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('lowerLipDepressorRight', 'text', ['label' => 'Coordinates between 0 and 1',])
            ->add('happy', 'text', ['label' => '0 for neutral and 1 for happy',])
            ->add('heartRate', 'text', ['label' => 'Number of heart beat per minute',]);
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