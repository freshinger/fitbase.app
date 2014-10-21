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

class QuestionnaireQuestionSelectboxType extends QuestionnaireQuestionAbstractType
{
    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $choices = array();
        if (($collection = $this->getCollectionAnswer())) {
            foreach ($collection as $answer) {
                $choices[$answer->getId()] = $answer->getName();
            }
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
            'required' => true,
            'empty_value' => false,
            'attr' => array(
                'style' => 'width: 100%'
            )
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
        return 'questionnaire_selectbox';
    }
}
