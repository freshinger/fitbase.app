<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionSliderType extends AbstractType
{
    protected $values;

    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * Set variables for template engine
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['min'] = min($this->values);
        $view->vars['def'] = $this->values[floor(count($this->values) / 2)];
        $view->vars['max'] = max($this->values);
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
        return 'slider';
    }
}
