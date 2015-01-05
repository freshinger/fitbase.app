<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusCategoriesPriorityForm extends AbstractType
{

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'allow_add' => false,
            'allow_delete' => false,
            'type' => new UserFocusCategoryPriorityForm(),
        ));
    }


    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'user_focus_priority_categories';
    }
}