<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationUserDialogAnswerFeedbackForm extends GamificationUserDialogAnswerAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('submit', 'submit', array(
                'label' => 'Ok',
                'attr' => array(
                    'style' => 'margin: 7px; width: 60px',
                    'class' => 'btn btn-success btn-ds',
                ),
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

        $repositoryGamificationUserDialogFeedback = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogFeedback');

        $user = $this->container->get('user')->current();
        if (($feedback = $repositoryGamificationUserDialogFeedback->findTextRandomByUserAndPositive($user))) {
            $view->vars['feedback'] = $feedback->getText();
        }
    }
}
