<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BooleanButtonsType extends AbstractType
{
    public function getParent()
    {
        return 'hidden';

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'boolean_buttons';
    }
}
