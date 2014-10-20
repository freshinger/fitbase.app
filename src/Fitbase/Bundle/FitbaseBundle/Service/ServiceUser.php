<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/25/14
 * Time: 2:44 PM
 */

namespace Fitbase\Bundle\FitbaseBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceUser extends ContainerAware
{
    /**
     * Get current user
     * @return mixed
     */
    public function current()
    {
        if (($token = $this->container->get('security.context')->getToken())) {

            if (($user = $token->getUser())) {
                return $user;
            }
        }
        return null;
    }
}