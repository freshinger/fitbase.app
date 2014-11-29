<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;


class WeeklyquizUserForm extends AbstractType implements ContainerAwareInterface
{
    protected $container;

    /**
     * Store user quiz entity
     * @var WeeklyquizUser
     */
    protected $weeklytaskUserQuiz;
    protected $collectionWeeklyTaskQuizQuestion;

    /**
     * Set user quiz entity
     * @param WeeklyquizUser $weeklytaskUserQuiz
     * @return $this
     */
    public function setWeeklyquizUser(WeeklyquizUser $weeklytaskUserQuiz = null)
    {
        $this->weeklytaskUserQuiz = $weeklytaskUserQuiz;

        $repositoryWeeklyquizQuestion = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');

        $this->collectionWeeklyTaskQuizQuestion = $repositoryWeeklyquizQuestion
            ->findAllByWeeklyquizUser($this->weeklytaskUserQuiz);

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
        if (!is_object($this->weeklytaskUserQuiz)) {
            return;
        }


        $repositoryWeeklyquizQuestion = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');

        if (!empty($this->collectionWeeklyTaskQuizQuestion)) {
            foreach ($this->collectionWeeklyTaskQuizQuestion as $weeklytaskQuestion) {

                $weeklytaskQuestionType = new WeeklyquizQuestionType();
                $weeklytaskQuestionType->setContainer($this->container);
                $weeklytaskQuestionType->setWeeklyquizQuestion($weeklytaskQuestion);

                $label = $weeklytaskQuestion->getName();
                if ($weeklytaskQuestion->getCountPoint()) {
                    if ($weeklytaskQuestion->getCountPoint() == 1) {
                        $label .= " <small>({$weeklytaskQuestion->getCountPoint()} Punkt)</small>";
                    } else {
                        $label .= " <small>({$weeklytaskQuestion->getCountPoint()} Punkte)</small>";
                    }
                }

                $builder->add($weeklytaskQuestion->getId(), $weeklytaskQuestionType, array(
                    'label' => $label,
                    'required' => true,
                    'expanded' => true,
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

        if (!is_object($this->weeklytaskUserQuiz)) {
            return;
        }

        $countPointTotal = $this->weeklytaskUserQuiz->getCountPoint();
        if (!empty($this->collectionWeeklyTaskQuizQuestion)) {
            foreach ($this->collectionWeeklyTaskQuizQuestion as $weeklytaskQuestion) {
                $countPointTotal += $weeklytaskQuestion->getCountPoint();
            }
        }

        $view->vars['points'] = $countPointTotal;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask_user_quiz';
    }
}
