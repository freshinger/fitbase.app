<?php

namespace Fitbase\Bundle\ExerciseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeedingUserForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'sonata_type_date_picker', array(
                'attr' => array(
                    'class' => 'sonata-medium-date form-control'
                ),
            ))
            ->add('items', 'sonata_type_collection', array(
                'type' => new FeedingUserItemForm(),
            ))
            ->add('submit', 'submit', array(
                'label' => 'Speichern',
                'attr' => array(
                    'class' => 'btn btn-info btn-ds',
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fitbase_bundle_exercisebundle_feedinguser';
    }
}
