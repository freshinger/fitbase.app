<?php
namespace Fitbase\Bundle\UserBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostHelper extends \Twig_Extension implements ContainerAwareInterface
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

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('video', array($this, 'getVideo')),
            new \Twig_SimpleFilter('token', array($this, 'getToken')),
            new \Twig_SimpleFilter('images', array($this, 'getImages')),
            new \Twig_SimpleFilter('title', array($this, 'getTitleById')),


        );
    }

    public function getTitleById($postId)
    {
//        if (($post = $this->container->get('ekino.wordpress.manager.post')->find($postId))) {
//            return $post->getTitle();
//        }
        return null;
    }

    /**
     * Get image id collection
     * @param $post
     * @return array
     */
    public function getImages($post)
    {
        if (($uploadDir = $this->container->get('fitbase_wordpress.api')->wpUploadDir())) {
            if (isset($uploadDir['path']) and ($dir = $uploadDir['path'])) {

                $path = "$dir/pictures/picture_{$post->getId()}_*.jpeg";

                $result = array();
                for ($i = 1; $i <= count(glob($path)); $i++) {
                    array_push($result, "/wp-content/uploads/pictures/picture_{$post->getId()}_{$i}.jpeg");
                }
                return $result;
            }
        }
        return array();
    }

    /**
     * Generate post token
     * @param $post
     * @return mixed
     */
    public function getToken($post)
    {
        return $this->container->get('fitbase_wordpress.api')
            ->wpCreateNonce('update_statistic_action');
    }

    /**
     * Get video code
     * @param $post
     * @return null
     */
    public function getVideo($post)
    {
        if (($uploadDir = $this->container->get('fitbase_wordpress.api')->wpUploadDir())) {
            if (isset($uploadDir['baseurl']) and ($dir = $uploadDir['baseurl'])) {
                return $this->container->get('fitbase_wordpress.api')->wpVideoShortcode(array(
                    'autoplay' => 'on',
                    'preload' => 'auto',
                    'mp4' => "$dir/videos/video_{$post->getId()}.mp4",
                ));
            }
        }
        return null;
    }

    public function getName()
    {
        return 'fitbase_post_extension';
    }
}