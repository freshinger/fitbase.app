<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationUserDialogAnswerTrashForm extends GamificationUserDialogAnswerAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionId', 'hidden')
            ->add('trash', 'submit', array(
                'label' => 'Wegschmeiẞen',
                'attr' => array(
                    'style' => 'margin: 7px',
                    'class' => 'btn btn-success btn-ds',
                ),
            ));
    }
}
