<?php

namespace Fitbase\Bundle\ExerciseBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class ExerciseUserTaskRepository extends EntityRepository
{
    /**
     * Get expression by user
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('ExerciseUserTask.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $queryBuilder
     * @param null $id
     * @return mixed
     */
    protected function getExprId($queryBuilder, $id = null)
    {
        if (!empty($id)) {
            $queryBuilder->setParameter('id', $id);
            return $queryBuilder->expr()->eq('ExerciseUserTask.id', ':id');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $user
     * @param $unique
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndUnique($user, $unique)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserTask');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprId($queryBuilder, $unique)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
