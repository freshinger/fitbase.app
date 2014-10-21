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

class QuestionnaireQuestionCheckboxType extends QuestionnaireQuestionAbstractType
{

    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'multiple' => true,
            'expanded' => true,
            'required' => true,
        ));
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
        return 'questionnaire_checkbox';
    }
}
