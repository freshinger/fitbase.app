<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class GamificationUserDialogAnswerAbstractForm extends AbstractType implements ContainerAwareInterface
{
    protected $container;

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gamification_dialog_user_answer';
    }
}
