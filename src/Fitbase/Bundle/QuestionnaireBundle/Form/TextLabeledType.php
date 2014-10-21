<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextLabeledType extends AbstractType
{
    /**
     * Custom field text
     * @var
     */
    protected $text;

    /**
     * Class constructor
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Set variables for template engine
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['text'] = $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'text_labeled';
    }
}
