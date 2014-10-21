<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationDialogQuestionTextForm extends GamificationDialogQuestionAbstractForm
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
            ->add('positive', 'choice', array(
                'required' => true,
                'label' => 'Sollte der Benutzer hier was positives schreiben?',
                'empty_value' => false,
                'choices' => array(
                    0 => 'Nein',
                    1 => 'Ja'
                ),
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
                'label' => 'Folgende Frage wird angezeigt nachdem der Benutzer diese Frage beantwortet',
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
