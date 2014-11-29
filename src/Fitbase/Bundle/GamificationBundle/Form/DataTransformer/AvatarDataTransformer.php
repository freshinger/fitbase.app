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
        'bear' => 'FitbaseGamificationBundle:SVG:avatar_bear.svg.twig',
        'crane' => 'FitbaseGamificationBundle:SVG:avatar_crane.svg.twig',
        'deer' => 'FitbaseGamificationBundle:SVG:avatar_deer.svg.twig',
        'monkey' => 'FitbaseGamificationBundle:SVG:avatar_monkey.svg.twig',
        'tiger' => 'FitbaseGamificationBundle:SVG:avatar_tiger.svg.twig',
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