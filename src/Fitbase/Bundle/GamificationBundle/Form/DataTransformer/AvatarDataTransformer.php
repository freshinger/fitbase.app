<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AvatarDataTransformer implements DataTransformerInterface, ContainerAwareInterface
{
    protected $association = array(
        'bear' => 'FitbaseGamificationBundle:Service:avatar_bear.html.twig',
        'crane' => 'FitbaseGamificationBundle:Service:avatar_crane.html.twig',
        'deer' => 'FitbaseGamificationBundle:Service:avatar_deer.html.twig',
        'monkey' => 'FitbaseGamificationBundle:Service:avatar_monkey.html.twig',
        'tiger' => 'FitbaseGamificationBundle:Service:avatar_tiger.html.twig',
    );

    /**
     * Store container
     * @var
     */
    protected $container;

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        return null;
    }

    /**
     * Transform from html to entity id
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value)
    {
        if (isset($this->association[$value])) {
            $render = $this->container->get('templating')->render(
                $this->association[$value]
            );
            return trim($render);
        }
        return null;
    }
}