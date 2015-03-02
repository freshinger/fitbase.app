<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskUserQuiz;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;


class QuestionnaireUserForm extends AbstractType
{

    /**
     * Service Container
     * @var
     */
    protected $container;

    /**
     * Store user quiz entity
     * @var WeeklytaskUserQuiz
     */
    protected $questionnaireUser;


    /**
     * @var
     */
    protected $questions;

    protected $questionsCount;

    /**
     * Class cosntructor
     * @param ContainerInterface $container
     * @param QuestionnaireUser $questionnaireUser
     */
    public function __construct(ContainerInterface $container = null, QuestionnaireUser $questionnaireUser, $limit = 10)
    {
        $this->container = $container;
        $this->questionsCount = $limit;
        $this->questionnaireUser = $questionnaireUser;
    }

    /**
     * Calculate question form type
     * @param $question
     * @return QuestionnaireQuestionCheckboxType|QuestionnaireQuestionRadiobuttonType|QuestionnaireQuestionSelectboxType|QuestionnaireQuestionSliderType|QuestionnaireQuestionTextType
     */
    protected function getQuestionFormType($question)
    {
        switch ($question->getType()) {
            case 'checkbox':
                return new QuestionnaireQuestionCheckboxType($this->container, $question);
            case 'selectbox':
                return new QuestionnaireQuestionSelectboxType($this->container, $question);
            case 'slider':
                return new QuestionnaireQuestionSliderType($this->container, $question);
            case 'text':
                return new QuestionnaireQuestionTextType($this->container, $question);
        }
        return new QuestionnaireQuestionRadiobuttonType($this->container, $question);
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        assert(is_object($this->questionnaireUser));

        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskQuestion = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');

        if (($this->questions = $repositoryWeeklytaskQuestion->findAllByQuestionnaireUser($this->questionnaireUser, $this->questionsCount))) {
            foreach ($this->questions as $question) {
                $builder->add($question->getId(), $this->getQuestionFormType($question), array(
                    'label' => $question->getName(),
                    'required' => false,
                ));
            }
        }
    }


    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['questions_count'] = null;

        $entityManager = $this->container->get('entity_manager');
        $repositoryQuestionnaireQuestion = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');

        if (($questions_count = $repositoryQuestionnaireQuestion->findCountByQuestionnaireUser($this->questionnaireUser))) {
            $view->vars['questions_count'] = $questions_count - count($this->questions);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'questionnaire_user';
    }
}
