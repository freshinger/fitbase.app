<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/12/14
 * Time: 12:40 PM
 */

namespace Fitbase\Bundle\ExerciseBundle\Helper;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class MediaHelper extends \Twig_Extension implements ContainerAwareInterface
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

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('video', array($this, 'getVideo')),
        );
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('video', array($this, 'getVideo')),
        );
    }

    /**
     * Get video
     * @param $media
     * @return null
     */
    public function getVideo($media)
    {
        return $this->container->get('fitbase.media.provider.video')->generatePublicUrl($media, 'video');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_media';
    }
} 