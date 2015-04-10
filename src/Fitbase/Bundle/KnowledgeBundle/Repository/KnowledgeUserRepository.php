<?php

namespace Fitbase\Bundle\KnowledgeBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * KnowledgeUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KnowledgeUserRepository extends EntityRepository
{
    /**
     * Get expression by user
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('KnowledgeUser.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $queryBuilder
     * @param $datetime
     * @return mixed
     */
    protected function getExprDateTime($queryBuilder, $datetime)
    {
        if (!empty($datetime)) {

            $queryBuilder->setParameter('datetime', $datetime);
            return $queryBuilder->expr()->eq('KnowledgeUser.doneDate', ':datetime');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLast($user)
    {
        $queryBuilder = $this->createQueryBuilder('KnowledgeUser');
        $queryBuilder->andWhere($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->orderBy('KnowledgeUser.id', 'DESC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastByDate($user, $datetime)
    {
        $queryBuilder = $this->createQueryBuilder('KnowledgeUser');
        $queryBuilder->andWhere($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDateTime($queryBuilder, $datetime)
        ));

        $queryBuilder->orderBy('KnowledgeUser.id', 'DESC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
