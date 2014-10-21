<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class DatePickerType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'datepicker'
            )
        ));
    }

    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'date_picker';
    }
}