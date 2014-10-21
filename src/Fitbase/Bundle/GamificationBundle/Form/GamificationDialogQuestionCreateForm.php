<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationDialogQuestionCreateForm extends GamificationDialogQuestionAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'text', array(
                'label' => 'Name',
            ))
            ->add('description', 'tinymce', array(
                'label' => 'Beitrag',
            ))
            ->add('start', 'choice', array(
                'required' => true,
                'label' => 'Ist es die erste Frage',
                'empty_value' => false,
                'choices' => $this->getChoiceStart(),
            ))
            ->add('type', 'choice', array(
                'required' => false,
                'label' => 'Type',
                'empty_value' => false,
                'choices' => $this->getChoiceType(),
            ))
            ->add('save', 'submit', array(
                'label' => 'Anlegen',
                'attr' => array(
                    'class' => 'button button-primary',
                ),
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gamification_dialog_question';
    }
}
