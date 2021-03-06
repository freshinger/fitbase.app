<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationUserDialogAnswerFinishForm extends GamificationUserDialogAnswerAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', 'hidden');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gamification_dialog_user_answer_finish';
    }
}
