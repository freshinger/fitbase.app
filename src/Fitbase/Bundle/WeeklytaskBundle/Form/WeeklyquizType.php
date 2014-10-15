<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 9:46 AM
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Form;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklyquizType extends AbstractType implements ContainerAwareInterface
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $repositoryWeeklyquiz = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

        $choices = array();
        foreach ($repositoryWeeklyquiz->findAll() as $quiz) {
            $choices[$quiz->getId()] = $quiz->getName();
        }

        $resolver->setDefaults(array(
            'empty_value' => 'Wählen sie ein Quiz',
            'choices' => $choices,
            'required' => true,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'quiz';
    }
} 