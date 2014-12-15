<?php

namespace Fitbase\Bundle\ExerciseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExerciseUserRepository extends EntityRepository
{
    /**
     * Get all not processed tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function  getExprNotProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('ExerciseUser.processed', ':processed'),
            $queryBuilder->expr()->isNull('ExerciseUser.processed')
        );
    }

    /**
     * @param $queryBuilder
     * @param $datetime
     * @return mixed
     */
    protected function getExprDateTimeLt($queryBuilder, $datetime)
    {
        if (!empty($datetime)) {
            $queryBuilder->setParameter('datetime', $datetime);
            return $queryBuilder->expr()->lt('ExerciseUser.date', ':datetime');
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
            return $queryBuilder->expr()->eq('ExerciseUser.date', ':datetime');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Get expression by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('ExerciseUser.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find records by exercise
     * @param $queryBuilder
     * @param null $exercise
     * @return mixed
     */
    protected function getExprExercise($queryBuilder, $exercise = null)
    {
        if (!empty($exercise)) {
            $queryBuilder->setParameter('exercise', $exercise);
            return $queryBuilder->expr()->orx(
                $queryBuilder->expr()->eq('ExerciseUser.exercise0', ':exercise'),
                $queryBuilder->expr()->eq('ExerciseUser.exercise1', ':exercise'),
                $queryBuilder->expr()->eq('ExerciseUser.exercise2', ':exercise')
            );
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
            return $queryBuilder->expr()->eq('ExerciseUser.id', ':id');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * @param $user
     * @param $exercise
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndExercise($user, $exercise)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprExercise($queryBuilder, $exercise)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * @param $user
     * @param $datetime
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndDateTime($user, $datetime)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDateTime($queryBuilder, $datetime)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     *
     * @param $datetime
     * @return array
     */
    public function findAllNotProcessedByDateTime($datetime)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprDateTimeLt($queryBuilder, $datetime),
            $this->getExprNotProcessed($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     *
     * @param $user
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndId($user, $id)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprId($queryBuilder, $id)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
