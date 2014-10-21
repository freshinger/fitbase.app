<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationUserDialogAnswerBooleanForm extends GamificationUserDialogAnswerAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'hidden')
            ->add('questionId', 'hidden')
            ->add('true', 'submit', array(
                'label' => 'Ja',
                'attr' => array(
                    'style' => 'margin: 7px; width: 60px',
                    'class' => 'btn btn-success btn-ds',
                ),
            ))
            ->add('false', 'submit', array(
                'label' => 'Nein',
                'attr' => array(
                    'style' => 'margin: 7px; width: 60px',
                    'class' => 'btn btn-danger btn-ds',
                ),
            ));
    }
}
