<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskQuestion;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class QuestionnaireQuestionAbstractType extends AbstractType implements ContainerAwareInterface
{
    /**
     * Service container
     * @var
     */
    protected $container;

    /**
     * WeeklytaskQuestion entity
     * @var
     */
    protected $questionnaireQuestion;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Set questionnaire question and container
     * @param ContainerInterface $container
     * @param QuestionnaireQuestion $questionnaireQuestion
     */
    public function __construct(ContainerInterface $container, QuestionnaireQuestion $questionnaireQuestion)
    {
        $this->container = $container;
        $this->questionnaireQuestion = $questionnaireQuestion;
    }


    /**
     * Get collection with answer
     * @return mixed
     */
    protected function getCollectionAnswer()
    {
        return $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer')
            ->findAllByQuestion($this->questionnaireQuestion);
    }

    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $choices = array();
        if (($collection = $this->getCollectionAnswer())) {
            foreach ($collection as $answer) {
                $choices[$answer->getId()] = "<h6>{$answer->getName()}</h6>";
            }
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
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

        $view->vars['question'] = $this->questionnaireQuestion;
        $view->vars['description'] = $this->questionnaireQuestion->getDescription();
    }
}
