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
    public function __construct(UserFocusCategory $userFocusCategory, $translator = null)
    {
        $this->userFocusCategory = $userFocusCategory;
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
                    1 => $this->_('user.focus.category_settings_type_1'),
                    2 => $this->_('user.focus.category_settings_type_2'),
                    0 => $this->_('user.focus.category_settings_type_0'),
                )
            ))
            ->add('save', 'submit', array(
                'label' => $this->_('user.focus.category_settings_type_save'),
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