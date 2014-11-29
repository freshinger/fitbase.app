<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationUserDialogAnswerNoticeForm extends GamificationUserDialogAnswerAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('submit', 'submit', array(
                'label' => 'Ok',
                'attr' => array(
                    'style' => 'margin: 7px; width: 60px',
                    'class' => 'btn btn-success btn-ds',
                ),
            ));
    }
}
