<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskQuestion;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion;
use Fitbase\Bundle\QuestionnaireBundle\Form\DataTransformer\QuestionnaireQuestionDataTransformerSlider;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireQuestionSliderType extends QuestionnaireQuestionAbstractType
{
    /**
     * Data transformer object
     * @var
     */
    protected $transformer;

    /**
     * Define data transformer in constructor
     * @param ContainerInterface $container
     * @param QuestionnaireQuestion $questionnaireQuestion
     */
    public function __construct(ContainerInterface $container, $questionnaire, QuestionnaireQuestion $questionnaireQuestion)
    {
        parent::__construct($container, $questionnaire, $questionnaireQuestion);

        $this->transformer = new QuestionnaireQuestionDataTransformerSlider($this->getCollectionAnswer());
    }

    /**
     * Get collection with answer
     * @return mixed
     */
    protected function getCollectionAnswer()
    {
        return $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer')
            ->findAllByQuestionAndOrderByName($this->questionnaireQuestion);
    }

    /**
     * Build form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer($this->transformer);
    }

    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required' => true,
            'choices' => $this->transformer->getChoices(),
        ));
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (empty($view->vars['value'])) {
            if (($keys = array_keys($options['choices']))) {
                $view->vars['value'] = floor((count($keys) / 2));
            }
        }

        $view->vars['min'] = min($options['choices']);
        $view->vars['max'] = max($options['choices']);
    }

    /**
     * Get parent element
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
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
        return 'questionnaire_slider';
    }
}
