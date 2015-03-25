<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusCategoryForm extends AbstractType
{
    protected $userFocusCategory;

    public function __construct(UserFocusCategory $userFocusCategory)
    {
        $this->userFocusCategory = $userFocusCategory;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('primaries', null, array(
                'label' => false,
                'expanded' => true,
                'empty_value' => false,
                'query_builder' => function (EntityRepository $repository) {

                    $queryBuilder = $repository->createQueryBuilder('UserFocusCategory');
                    $queryBuilder->join('UserFocusCategory.category', 'Category');

                    $queryBuilder->where($queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('Category.parent', ':parent'),
                        $queryBuilder->expr()->eq('UserFocusCategory.focus', ':focus')
                    ));
                    $queryBuilder->setParameter(':focus', $this->userFocusCategory->getFocus());
                    $queryBuilder->setParameter(':parent', $this->userFocusCategory->getCategory());

                    $queryBuilder->orderBy('Category.position', 'ASC');

                    return $queryBuilder;
                }
            ))
            ->add('type', 'choice', array(
                'label' => false,
                'expanded' => true,
                'empty_value' => false,
                'choices' => array(
                    1 => 'Überwiegend Mobilisation',
                    2 => 'Überwiegend Kräftigung',
                    0 => 'Mobilisation, Kräftigung und Dehnung',
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Speichern',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ));;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('user'),
            'data_class' => 'Fitbase\Bundle\UserBundle\Entity\UserFocusCategory'
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'user_focus_category';
    }
}