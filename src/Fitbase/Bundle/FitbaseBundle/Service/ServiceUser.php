<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/25/14
 * Time: 2:44 PM
 */

namespace Fitbase\Bundle\FitbaseBundle\Service;


use Cocur\Slugify\Slugify;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
     * Get unique username
     * @param $user
     * @return string
     */
    public function getUniqueUsername($user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        $username = (new Slugify())->slugify("{$user->getFirstname()}_{$user->getLastName()}");
        while (($collection = $repositoryUser->findByUsername($username))) {
            $username = $username . count($collection);
        }
        return $username;
    }


    /**
     * Check is user has a role
     * @param $user
     * @param $role
     * @return bool
     */
    public function isGranted($user, $role = null)
    {
        $securityContext = $this->container->get('security.context');
        $securityContext->setToken(new UsernamePasswordToken($user, null, 'main', $user->getRoles()));

        return $securityContext->isGranted($role, $user);
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

            // TODO: switch without sites
            $token = new UsernamePasswordToken($user, $password, "main", $user->getRoles());
            $securityContext = $this->container->get('security.context');
            $securityContext->setToken($token);

            $company = $this->container->get('company')->current($user);
            return $this->container->get('twig.extension.routing')->getUrl('dashboard', array(), false, $company);
        }

        return false;
    }
}