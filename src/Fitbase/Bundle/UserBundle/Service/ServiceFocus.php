<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\UserBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceFocus extends ContainerAware
{
    /**
     * Get user focus
     * @param $user
     * @return mixed
     */
    public function focus($user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUserFocus = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocus');
        return $repositoryUserFocus->findOneByUser($user);
    }
}