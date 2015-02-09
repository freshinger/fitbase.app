<?php

namespace Fitbase\Bundle\ScheduleBundle\Form;

use JMose\CommandSchedulerBundle\Form\CommandChoiceList;
use JMose\CommandSchedulerBundle\Form\Type\ScheduledCommandType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ScheduledCommandType
 *
 * @author  Julien Guyon <julienguyon@hotmail.com>
 * @package JMose\CommandSchedulerBundle\Form\Type
 */
class ScheduledCommandForm extends ScheduledCommandType
{

    /**
     * @var CommandChoiceList
     */
    protected $choiceListService;

    /**
     * @param CommandChoiceList $choiceListService
     */
    public function __construct(CommandChoiceList $choiceListService)
    {
        $this->choiceListService = $choiceListService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');

        $builder->add(
            'name', 'text', array(
                'label' => 'commandeScheduler.detail.name',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'name'
                ),
            )
        );

        $builder->add(
            'command', 'choice', array(
                'choice_list' => $this->choiceListService,
                'label' => 'commandeScheduler.detail.command',
                'required' => true,
                'attr' => array(),
            )
        );

        $builder->add(
            'arguments', 'text', array(
                'label' => 'commandeScheduler.detail.arguments',
                'required' => false,
                'attr' => array(
                    'placeholder' => '--argument1=foo --bar'
                ),
            )
        );

        $builder->add(
            'cronExpression', 'text', array(
                'label' => 'commandeScheduler.detail.cronExpression',
                'required' => true,
                'attr' => array(
                    'placeholder' => '*/10 * * * *'
                ),
            )
        );

        $builder->add(
            'logFile', 'text', array(
                'label' => 'commandeScheduler.detail.logFile',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'myFile.log'
                ),
            )
        );

        $builder->add(
            'priority', 'integer', array(
                'label' => 'commandeScheduler.detail.priority',
                'empty_data' => 0,
                'required' => false,
                'attr' => array(
                ),
            )
        );

        $builder->add(
            'executeImmediately', 'checkbox', array(
                'label' => 'commandeScheduler.detail.executeImmediately',
                'required' => false,
                'attr' => array(
                ),
            )
        );

        $builder->add(
            'disabled', 'checkbox', array(
                'label' => 'commandeScheduler.detail.disabled',
                'required' => false,
                'attr' => array(
                ),
            )
        );

        $builder->add(
            'save', 'submit', array(
                'label' => 'commandeScheduler.detail.save',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            )
        );

    }
}
