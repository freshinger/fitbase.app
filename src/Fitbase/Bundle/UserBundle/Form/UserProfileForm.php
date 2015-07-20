<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserProfileForm extends AbstractType
{
    protected $class;

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
    public function __construct($class, $translator = null)
    {
        $this->class = $class;
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
            return $this->translator->trans($code, [], 'FitbaseUserBundle');
        }

        return $code;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel', 'text', array(
                'required' => false,
                'label' => $this->_('user.profile.details_title'),
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('gender', 'choice', array(
                'required' => false,
                'label' => $this->_('user.profile.details_salutation'),
                'choices' => array(
                    'f' => $this->_('user.profile.details_salutation_ms'),
                    'm' => $this->_('user.profile.details_salutation_mr'),
                ),
                'empty_value' => $this->_('user.profile.details_salutation_make_a_choice'),
            ))
            ->add('firstname', 'text', array(
                'required' => false,
                'label' => $this->_('user.profile.details_first_name'),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('lastname', 'text', array(
                'required' => false,
                'label' => $this->_('user.profile.details_last_name'),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => $this->_('user.profile.details_email'),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('save', 'submit', array(
                'label' => $this->_('user.profile.details_save'),
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'fitbase_user_profile';
    }
}