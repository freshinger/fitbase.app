<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/12/14
 * Time: 12:40 PM
 */

namespace Fitbase\Bundle\GamificationBundle\Helper;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion;
use Fitbase\Bundle\GamificationBundle\Form\DataTransformer\GamificationEmotionDataTransformer;
use \Graph;
use \JpGraph\JpGraph;
use \UniversalTheme;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class GamificationPictureHelper extends \Twig_Extension implements ContainerAwareInterface
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
     * Get functions for twig extension
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('avatarPreview', array($this, 'avatarPreview')),
        );
    }

    /**
     * Display current active avatar from gallery
     * @TODO: show with respect to month
     * @param $unique
     * @return string
     */
    public function avatarPreview($unique)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryAvatar = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar');

        if (($gallery = $repositoryAvatar->find($unique))) {
            if (($collection = $gallery->getGalleryHasMedia())) {
                if (($hasMedia = $collection->get(0))) {
                    if (($media = $hasMedia->getMedia())) {
                        return sprintf('<img src="%s"  />',
                            $this->container->get('sonata.media.twig.extension')
                                ->path($media, 'icon'));
                    }
                }
            }
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_gamification_picture_extension';
    }
} 