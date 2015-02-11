<?php

namespace Fitbase\Bundle\UserBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceWordpress extends ContainerAware
{
    /**
     * @deprecated
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->getCurrentPost();
    }

    /**
     * Get Post url
     * @api wordpress bridge
     * @param $post
     * @return mixed
     */
    public function getPostLink($post)
    {
        return get_permalink($post->getId());
    }

    /**
     * @return mixed
     */
    public function current()
    {
        $current_user = $this->container
            ->get('fitbase_wordpress.api')
            ->wpGetCurrentUser();

        return $this->container
            ->get('user')
            ->find($current_user->ID);
    }


    /**
     * @return mixed
     */
    public function getCurrentPost()
    {
//        global $post;
//        return $this->container
//            ->get('ekino.wordpress.manager.post')
//            ->find($post->ID);
    }
}