<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 2:36 PM
 */

namespace Fitbase\Bundle\GamificationBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceGamificationCache extends ContainerAware
{
    /**
     * Set value to cache
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->container->get('session')->set($key, $value);
    }

    /**
     * Get value from cache
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->container->get('session')->get($key);
    }

    /**
     * Check is value in cache exists
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return $this->container->get('session')->has($key);
    }
}