<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel', 'text', array(
                'required' => false,
                'label' => 'Titel (optional)',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('anrede', 'choice', array(
                'required' => false,
                'label' => 'Anrede',
                'choices' => array(
                    'Frau' => 'Frau',
                    'Herr' => 'Herr',
                ),
                'empty_value' => 'Bitte wählen',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('vorname', 'text', array(
                'required' => false,
                'label' => 'Vorname',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nachname', 'text', array(
                'required' => false,
                'label' => 'Nachname',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
//            ->add('strasse', 'text', array(
//                'required' => false,
//                'label' => 'Straße',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
//            ->add('hausnummer', 'text', array(
//                'required' => false,
//                'label' => 'Hausnummer',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
//            ->add('postzahl', 'text', array(
//                'required' => false,
//                'label' => 'Postleitzahl',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
//            ->add('ort', 'text', array(
//                'required' => false,
//                'label' => 'Ort',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
//            ->add('phone', 'text', array(
//                'required' => false,
//                'label' => 'Telefon',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
//            ->add('handy', 'text', array(
//                'required' => false,
//                'label' => 'Telefon Mobil',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'E-Mail-Adresse',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
//            ->add('geburtsdatum', 'birthday', array(
//                'required' => false,
//                'widget' => 'single_text',
//                'label' => 'Geburtsdatum',
//                'format' => 'yyyy-MM-dd',
//                'attr' => array(
//                    'class' => 'datepicker form-control',
//                ),
//            ))
            ->add('showInStatistic', 'checkbox', array(
                'required' => false,
                'label' => 'Namen nicht in den Statistiken anzeigen ',
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'profile';
    }
}