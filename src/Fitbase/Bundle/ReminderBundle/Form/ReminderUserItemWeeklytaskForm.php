<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 3:06 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReminderUserItemWeeklytaskForm extends AbstractType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', 'choice', array(
                'required' => false,
                'label' => 'Tag',
                'empty_value' => false,
                'choices' => array(
                    '1' => $this->_('reminder.weeklytask.day_1'),
                    '2' => $this->_('reminder.weeklytask.day_2'),
                    '3' => $this->_('reminder.weeklytask.day_3'),
                    '4' => $this->_('reminder.weeklytask.day_4'),
                    '5' => $this->_('reminder.weeklytask.day_5'),
                ),
                'attr' => array(
                    'class' => ' form-control'
                )
            ))
            ->add('time', 'time', array(
                'empty_value' => array('hour' => 'hh', 'minute' => 'mm'),
                'required' => false,
                'label' => $this->_('reminder.weeklytask.hour'),
            ))
            ->add('save', 'submit', array(
                'label' => $this->_('reminder.weeklytask.save'),
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'reminder_item_weeklytask';
    }
} 