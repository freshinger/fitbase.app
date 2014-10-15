<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 9:46 AM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklytaskPostType extends AbstractType implements ContainerAwareInterface
{
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $repositoryPost = $this->container->get('fitbase_entity_manager')
            ->getRepository('Ekino\WordpressBundle\Entity\Post');

        $choices = array();
        foreach ($repositoryPost->findBy(array('status' => 'publish')) as $post) {
            $choices[$post->getId()] = $post->getTitle();
        }

        $resolver->setDefaults(array(
            'empty_value' => 'Wählen sie ein Post',
            'choices' => $choices,
            'required' => true,
        ));
    }

    /**
     * Get parent element
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * Get element name for templater
     * @return string
     */
    public function getName()
    {
        return 'post';
    }
}