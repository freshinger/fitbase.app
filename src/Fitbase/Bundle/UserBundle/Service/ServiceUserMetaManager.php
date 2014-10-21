<?php

namespace Fitbase\Bundle\UserBundle\Service;

use Doctrine\ORM\AbstractQuery;
use Fitbase\Bundle\UserBundle\Entity\UserInterface;
use Fitbase\Bundle\UserBundle\Entity\UserMedimouse;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ServiceUserMetaManager extends \Ekino\WordpressBundle\Manager\UserMetaManager implements ContainerAwareInterface
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
     * Get user meta from user object
     * @param $user
     * @param $name
     * @return null
     */
    public function getUserMeta(\Ekino\WordpressBundle\Entity\User $user, $name)
    {
        foreach ($user->getMetas() as $meta) {
            if ($name == $meta->getKey()) {
                return $meta;
            }
        }
        return null;
    }

    /**
     * Save existed user meta
     * or create new user meta if not exist
     * @param $user
     * @param $name
     * @param $value
     * @return \Ekino\WordpressBundle\Entity\UserMeta|null
     */
    public function setUserMeta($user, $name, $value)
    {
        if (!($meta = $this->getUserMeta($user, $name))) {
            $meta = new \Ekino\WordpressBundle\Entity\UserMeta();
            $meta->setKey($name);
            $meta->setUser($user);
        }

        $meta->setValue($value);
        $this->save($meta);

        return $meta;
    }

    /**
     * Get count of user by user role name
     * @param $name
     * @return mixed
     */
    public function getUserCountByRole($name)
    {
        $queryBuilder = $this->getRepository()->createQueryBuilder('UserMeta');
        $queryBuilder->select('COUNT(UserMeta.id)')
            ->where($queryBuilder->expr()->eq('UserMeta.key', ':key'))
            ->setParameter('key', 'ors_capabilities')
            ->andWhere($queryBuilder->expr()->like('UserMeta.value', ':value'))
            ->setParameter('value', "%$name%");

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }


    /**
     * Get expression to find records by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    protected function getExprUserId($queryBuilder, $userId)
    {
        if (!empty($userId)) {
            $queryBuilder->setParameter('userId', $userId);
            return $queryBuilder->expr()->eq('UserMeta.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find records by key
     * @param $queryBuilder
     * @param $key
     * @return mixed
     */
    protected function getExprKey($queryBuilder, $key)
    {
        if (!empty($key)) {
            $queryBuilder->setParameter('key', $key);
            return $queryBuilder->expr()->eq('UserMeta.key', ':key');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find user meta by user id and key
     * @param $user
     * @param $key
     * @return mixed
     */
    public function findOneByUserAndKey($user, $key)
    {
        $queryBuilder = $this->getRepository()->createQueryBuilder('UserMeta');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserId($queryBuilder, $user->getId()),
            $this->getExprKey($queryBuilder, $key)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}