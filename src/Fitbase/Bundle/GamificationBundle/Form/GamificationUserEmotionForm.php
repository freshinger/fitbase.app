<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Fitbase\Bundle\GamificationBundle\Form\DataTransformer\GamificationEmotionDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationUserEmotionForm extends GamificationDialogQuestionAbstractForm
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', new GamificationEmotionType(), array(
            'required' => true,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gamification_user_emotion';
    }
}
