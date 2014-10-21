<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationDialogQuestionNoticeForm extends GamificationDialogQuestionAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'text', array(
                'required' => true,
                'label' => 'Name',
            ))
            ->add('type', 'choice', array(
                'required' => true,
                'label' => 'Type',
                'empty_value' => false,
                'choices' => $this->getChoiceType(),
            ))
            ->add('start', 'choice', array(
                'required' => true,
                'label' => 'Ist es die erste Frage',
                'empty_value' => false,
                'choices' => $this->getChoiceStart(),
            ))
            ->add('description', 'tinymce', array(
                'required' => false,
                'label' => 'Beschreibung',
            ))
            ->add('questionTrue', 'entity', array(
                'required' => true,
                'label' => 'Weiter wird die Folgende Frage gestellt',
                'empty_value' => 'Wählen sie bitte eine Frage',
                'class' => 'FitbaseGamificationBundle:GamificationDialogQuestion',
                'property' => 'text',
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
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
        return 'gamification_dialog_question_text';
    }
}
