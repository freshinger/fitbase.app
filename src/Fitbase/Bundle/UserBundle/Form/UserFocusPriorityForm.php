<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusPriorityForm extends AbstractType
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('parentCategories', new UserFocusCategoriesPriorityForm($this->user), array(
            'label' => false
        ))->add('save', 'submit', array(
            'label' => 'Speichern und Coaching aktivieren',
            'attr' => array(
                'class' => 'btn btn-primary',
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserFocus'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'user_focus_priority';
    }
}