<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserRegistrationForm extends AbstractType
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
            return $this->translator->trans($code, [], 'FitbaseUserBundle');
        }

        return $code;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actioncode', 'hidden')
            ->add('first_name', null, array(
                'label' => $this->_('user.registration.first_name'),
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('last_name', null, array(
                'label' => $this->_('user.registration.last_name'),
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email', null, array(
                'label' => $this->_('user.registration.email'),
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('terms', 'checkbox', array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('save', 'submit', array(
                'label' => $this->_('user.registration.button'),
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
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserRegistration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'userregistration';
    }
}
