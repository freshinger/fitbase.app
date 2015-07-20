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

class ReminderUserItemForm extends AbstractType
{
    protected $name;

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
    public function __construct($name = 'reminder_item', $translator = null)
    {
        $this->name = $name;
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
            ->add('day', 'choice', [
                'required' => false,
                'label' => $this->_('reminder.weeklytask.day'),
                'empty_value' => false,
                'choices' => [
                    '1' => $this->_('reminder.weeklytask.day_1'),
                    '2' => $this->_('reminder.weeklytask.day_2'),
                    '3' => $this->_('reminder.weeklytask.day_3'),
                    '4' => $this->_('reminder.weeklytask.day_4'),
                    '5' => $this->_('reminder.weeklytask.day_5'),
                ],
                'attr' => ['class' => ' form-control']
            ])
            ->add('time', 'time', [
                'empty_value' => ['hour' => 'hh', 'minute' => 'mm'],
                'required' => false,
                'label' => $this->_('reminder.weeklytask.hour'),
            ])
            ->add('save', 'submit', [
                'label' => $this->_('reminder.weeklytask.save'),
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem'
        ]);
    }

    public function getParent()
    {
        return 'form';
    }

    /**
     * Get form name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
} 