<?php

namespace Fitbase\Bundle\ExerciseBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;

class ExerciseUserReminderRepository extends EntityRepository
{
    protected function getExprNotId($queryBuilder, $entity = null)
    {
        if (!empty($entity)) {
            $queryBuilder->setParameter('not_id', $entity->getId());
            return $queryBuilder->expr()->neq('ExerciseUserReminder.id', ':not_id');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

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
            return $queryBuilder->expr()->eq('ExerciseUserReminder.user', ':user');
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
            return $queryBuilder->expr()->eq('ExerciseUserReminder.date', ':datetime');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $queryBuilder
     * @param $datetime
     * @return mixed
     */
    protected function getExprDateTimeLt($queryBuilder, $datetime)
    {
        if (!empty($datetime)) {
            $queryBuilder->setParameter('datetimelt', $datetime);
            return $queryBuilder->expr()->lt('ExerciseUserReminder.date', ':datetimelt');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get all not processed tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function  getExprNotProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('ExerciseUserReminder.processed', ':processed'),
            $queryBuilder->expr()->isNull('ExerciseUserReminder.processed')
        );
    }

    /**
     * Get all not processed tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', true);
        return $queryBuilder->expr()->eq('ExerciseUserReminder.processed', ':processed');
    }

    /**
     * Try to found object for given date
     *
     * @param ExerciseUserReminder $entity
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function exists(ExerciseUserReminder $entity)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserReminder');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $entity->getUser()),
            $this->getExprDateTime($queryBuilder, $entity->getDate())
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Check is exercise reminder with this data already processed
     * @param ExerciseUserReminder $entity
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function processed(ExerciseUserReminder $entity)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserReminder');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotId($queryBuilder, $entity),
            $this->getExprUser($queryBuilder, $entity->getUser()),
            $this->getExprDateTime($queryBuilder, $entity->getDate()),
            $this->getExprProcessed($queryBuilder)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     *
     * @param $datetime
     * @return array
     */
    public function findNotProcessed($datetime)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserReminder');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprDateTimeLt($queryBuilder, $datetime),
            $this->getExprNotProcessed($queryBuilder)
        ));

        $queryBuilder->orderBy('ExerciseUserReminder.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all by id
     *
     * @param array $array
     * @return array
     */
    public function findByIdArray($array = [])
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserReminder');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->in('ExerciseUserReminder.id', ':array')
        ));

        $queryBuilder->setParameter('array', $array);

        return $queryBuilder->getQuery()->getResult();
    }
}
