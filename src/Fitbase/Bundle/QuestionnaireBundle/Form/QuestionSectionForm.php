<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionSectionForm extends AbstractType
{
    protected $section;

    /**
     * Store service container here
     * @var
     */
    protected $container;

    /**
     * Class constructor
     * @param $container
     * @param $section
     */
    public function __construct($container, $section)
    {
        $this->section = $section;
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryResult = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Result');
        $repositoryAnswer = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Answer');
        $repositoryQuestion = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Question');

        $questions = $repositoryQuestion->findBy(array('section' => $this->section));

        if (!empty($questions)) {
            foreach ($questions as $question) {

                list($name, $type, $options) = $this->getFieldAttributes($question);

                $builder->add($name, $type, $options);
            }
        }
    }

    /**
     * Get field attributes
     * @param $question
     * @return array
     */
    protected function getFieldAttributes($question)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryResult = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Result');
        $repositoryAnswer = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Answer');

        $choices = $repositoryAnswer->getAnswerListChoice($question);
        if (count($choices) > 1) {

            list($type, $options) = $this->getFieldTypeAndOption($question, $choices);

            return array($question->getId(), $type, $options);
        }

        // Display text field with custom label
        // like: Name: ________ custom label
        return array($question->getId(), new TextLabeledType(array_shift($choices)), array(
            'required' => true,
            'label' => $question->getText(),
            'attr' => array(
                'maxlength' => 3,
                'class' => 'form-control'
            )
        ));
    }

    /**
     * @param $question
     * @param $choices
     * @return array
     */
    protected function getFieldTypeAndOption($question, $choices)
    {
        // Display multiple checkbox field
        // for question with id 2 and other
        if (in_array($question->getId(), array(2))) {
            return array('choice', array(
                'label' => $question->getText(),
                'choices' => $choices,
                'expanded' => true,
                'multiple' => true,
            ));
        }

        // Display multiple radio button for
        // questions with id in array
        if (in_array($question->getId(), array(3, 4))) {
            return array('choice', array(
                'required' => true,
                'label' => $question->getText(),
                'choices' => $choices,
                'expanded' => true,
            ));
        }

        // Display slider for
        // questions with id in array
        if (in_array($question->getId(), array(5, 9, 10, 11, 12, 15))) {

            $values = array_values($choices);
            array_filter($values, function (&$item, $key) {
                $item = (int)$item;
            });
            return array(new QuestionSliderType($values), array(
                'required' => true,
                'label' => $question->getText(),
            ));
        }

        // Display default selectbox
        // for all other fields
        return array('choice', array(
            'required' => true,
            'label' => $question->getText(),
            'choices' => $choices,
            'attr' => array(
                'class' => 'form-control'
            )
        ));
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'question_section';
    }
}
