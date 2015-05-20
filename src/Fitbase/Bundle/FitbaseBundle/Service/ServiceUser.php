<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/25/14
 * Time: 2:44 PM
 */

namespace Fitbase\Bundle\FitbaseBundle\Service;


use Cocur\Slugify\Slugify;
use Fitbase\Bundle\FitbaseBundle\Library\Interfaces\ServiceUserInterface;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Spy\Timeline\Model\ComponentInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ServiceUser extends ContainerAware implements ServiceUserInterface
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
     * Get admin group
     * @return mixed
     */
    protected function getAdminGroup()
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryGroup = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\Group');
        $queryBuilderGroup = $repositoryGroup->createQueryBuilder('g');

        $queryBuilderGroup->where($queryBuilderGroup->expr()->like('g.roles', ':roles'))
            ->setParameter('roles', '%ADMIN%');

        $queryBuilderGroup->setMaxResults(1);

        return $queryBuilderGroup->getQuery()->getOneOrNullResult();
    }

    /**
     * Returns corresponding users
     *
     * @return \Doctrine\ORM\Internal\Hydration\IterableResult
     */
    public function getAdmins()
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        $queryBuilder = $repositoryUser->createQueryBuilder('User');

        $queryBuilder->select('User')->where(
            $queryBuilder->expr()->orX(
                ':groups MEMBER OF User.groups'
            )
        )
            ->setParameter('groups', $this->getAdminGroup());

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get users, that wants to remove their accounts
     * @return mixed
     */
    public function getUsersToRemove()
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        $queryBuilder = $repositoryUser->createQueryBuilder('User');

        $datetime = $this->container->get('datetime');
        $date = $datetime->getDateTime('now');
        $date->modify('-2 week');

        $queryBuilder->where(
            $queryBuilder->expr()->eq("User.removeRequest", ':removeRequest'),
            $queryBuilder->expr()->lte("User.removeRequestAt", ':removeRequestAt')
        )
            ->setParameter('removeRequest', true)
            ->setParameter('removeRequestAt', $date);

        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * Get unique username
     * @TODO: check usage
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
     * @param $roles
     * @return bool
     */
    public function isGranted($user, $roles = null)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (!$this->isGranted($user, $role)) {
                    continue;
                }
                return true;
            }
        }

        $securityContext = $this->container->get('security.context');
        $securityContext->setToken(new UsernamePasswordToken($user, null, 'main', $user->getRoles()));

        return $securityContext->isGranted($roles, $user);
    }
}