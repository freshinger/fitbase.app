<?php

namespace Fitbase\Bundle\ReminderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ReminderUserPauseForm extends AbstractType
{
    /**
     * Translator object
     *
     * @var
     */
    protected $translator;

    /**
     * Class constructor
     *
     * @param $translator
     */
    public function __construct($translator = null)
    {
        $this->translator = $translator;
    }

    /**
     * Translate code if translator object exists
     *
     * @param $code
     * @return mixed
     */
    protected function _($code)
    {
        if (is_object($this->translator)) {
            return $this->translator->trans($code, [], 'FitbaseReminderBundle');
        }

        return $code;
    }

    /**
     *
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pause', 'choice', array(
                'required' => false,
                'label' => $this->_('reminder.profile.pause_question'),
                'choices' => array(
                    '1' => $this->_('reminder.profile.pause_1_weeks'),
                    '2' => $this->_('reminder.profile.pause_2_weeks'),
                    '3' => $this->_('reminder.profile.pause_3_weeks'),
                    '4' => $this->_('reminder.profile.pause_4_weeks'),
                ),
                'empty_value' => $this->_('reminder.profile.pause_make_a_choice'),
            ))
            ->add('save', 'submit', array(
                'label' => $this->_('reminder.profile.pause_save'),
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));

    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\ReminderBundle\Entity\ReminderUser'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'reminder_pause';
    }
}