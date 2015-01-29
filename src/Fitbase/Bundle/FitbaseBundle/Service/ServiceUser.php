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
            if (is_object(($user = $token->getUser()))) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Method to check is password and email correct
     * return a sinle sign-on link
     *
     * @param $login
     * @param $password
     * @return bool
     */
    public function login($login = null, $password = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        if (!($user = $repositoryUser->findOneByEmail($login))) {
            if (!($user = $repositoryUser->findOneByUsername($login))) {
                return false;
            }
        }

        // Get the encoder for the users password
        $encoder_service = $this->container->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);

        if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            return $this->container->get('fitbase_helper.user')->getSign($user,
                $this->container->get('router')->generate('page_slug', array(
                    'path' => '/'
                ), true)
            );
        }

        return false;
    }
}