<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 9:46 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Form;


use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\GamificationBundle\Form\DataTransformer\AvatarDataTransformer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvatarType extends AbstractType
{
    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => false,
            'class' => 'Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar',
            'required' => true,
            'expanded' => true,
        ));
    }

    /**
     * Get parent element
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * Get element name for templating
     * @return string
     */
    public function getName()
    {
        return 'avatar';
    }
}