<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserActioncodeForm extends AbstractType
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
        $builder->add('code', null, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ))
            ->add('save', 'submit', array(
                'label' => $this->_('user.actioncode'),
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserActioncode',
            'validation_groups' => array('registration'),
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'useractioncode';
    }
}
