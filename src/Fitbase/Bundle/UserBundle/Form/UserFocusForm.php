<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusForm extends AbstractType
{
    protected $user;

    public function __construct($user)
    {
//        parent::__construct();

        $this->user = $user;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', null, array(
                'query_builder' => function (EntityRepository $repository) {

                    $queryBuilder = $repository->createQueryBuilder('UserFocusCategory');
                    $queryBuilder->join('UserFocusCategory.focus', 'UserFocus');

                    $queryBuilder->where($queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('UserFocus.user', ':user')
                    ));
                    $queryBuilder->setParameter(':user', $this->user);

                    return $queryBuilder;
                }
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
        return 'user_focus';
    }
}