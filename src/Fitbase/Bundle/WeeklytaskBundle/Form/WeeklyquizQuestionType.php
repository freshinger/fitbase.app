<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Form;

use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklyquizQuestionType extends AbstractType implements ContainerAwareInterface
{

    /**
     * Service container
     * @var
     */
    protected $container;

    /**
     * WeeklyquizQuestion entity
     * @var
     */
    protected $weeklytaskQuestion;

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
     * Set weeklytask question object
     * @param WeeklyquizQuestion $weeklytaskQuestion
     * @return $this
     */
    public function setWeeklyquizQuestion(WeeklyquizQuestion $weeklytaskQuestion)
    {
        $this->weeklytaskQuestion = $weeklytaskQuestion;
        return $this;
    }

    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        assert(is_object(($weeklytaskQuestion = $this->weeklytaskQuestion)));

        switch ($weeklytaskQuestion->getType()) {
            case 'checkbox':
                $resolver->setDefaults(
                    $this->getDefaultsCheckbox(
                        $weeklytaskQuestion
                    )
                );
            default:
                $resolver->setDefaults(
                    $this->getDefaultsRadio(
                        $weeklytaskQuestion
                    )
                );
        }
    }

    /**
     * Get default settings for radio buttons
     * @param WeeklyquizQuestion $weeklytaskQuestion
     * @return array
     */
    public function getDefaultsRadio(WeeklyquizQuestion $weeklytaskQuestion)
    {
        $repositoryWeeklyquizAnswer = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');

        $collectionQuestions = $repositoryWeeklyquizAnswer->findBy(array(
            'questionId' => $weeklytaskQuestion->getId()
        ));


        $choices = array();
        if (count($collectionQuestions)) {
            foreach ($collectionQuestions as $answer) {
                $choices[$answer->getId()] = "<h6>{$answer->getName()}</h6>";
            }
        }

        return array(
            'choices' => $choices,
            'required' => true,
        );
    }

    /**
     * Get Default settings for checkbox
     * @param WeeklyquizQuestion $weeklytaskQuestion
     * @return array
     */
    public function getDefaultsCheckbox(WeeklyquizQuestion $weeklytaskQuestion)
    {
        $repositoryWeeklyquizAnswer = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');

        $collectionQuestions = $repositoryWeeklyquizAnswer->findBy(array(
            'questionId' => $weeklytaskQuestion->getId()
        ));

        $choices = array();
        if (count($collectionQuestions)) {
            foreach ($collectionQuestions as $answer) {
                $choices[$answer->getId()] = "<h6>{$answer->getName()}</h6>";
            }
        }

        return array(
            'multiple' => true,
            'required' => true,
            'choices' => $choices,
        );
    }


    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['description'] = $this->weeklytaskQuestion->getDescription();
    }


    /**
     * Get parent element
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'weeklytask_question';
    }
}
