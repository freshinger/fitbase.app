<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Form;

use Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskUserQuiz;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;


class QuestionnaireUserForm extends AbstractType implements ContainerAwareInterface
{
    protected $container;

    /**
     * Store user quiz entity
     * @var WeeklytaskUserQuiz
     */
    protected $questionnaireUser;
    protected $collectionQuestionnaireQuestion;


    public function setQuestionnaireUser(QuestionnaireUser $questionnaireUser)
    {
        $this->questionnaireUser = $questionnaireUser;

        $repositoryWeeklytaskQuestion = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');

        $this->collectionQuestionnaireQuestion = $repositoryWeeklytaskQuestion
            ->findAllByQuestionnaireUser($questionnaireUser);

        return $this;
    }

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
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        assert(is_object($this->questionnaireUser));
        assert(($collection = $this->collectionQuestionnaireQuestion));

        if (!empty($collection)) {
            foreach ($collection as $question) {

                switch ($question->getType()) {
                    case 'checkbox':
                        $weeklytaskQuestionType = new QuestionnaireQuestionCheckboxType($this->container, $question);
                        break;
                    case 'selectbox':
                        $weeklytaskQuestionType = new QuestionnaireQuestionSelectboxType($this->container, $question);
                        break;
                    case 'slider':
                        $weeklytaskQuestionType = new QuestionnaireQuestionSliderType($this->container, $question);
                        break;
                    case 'text':
                        $weeklytaskQuestionType = new QuestionnaireQuestionTextType($this->container, $question);
                        break;
                    default:
                        $weeklytaskQuestionType = new QuestionnaireQuestionRadiobuttonType($this->container, $question);
                        break;
                }

                $builder->add($question->getId(), $weeklytaskQuestionType, array(
                    'label' => $question->getName(),
                    'required' => false,
                ));
            }
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
