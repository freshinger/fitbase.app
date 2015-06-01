<?php

namespace Fitbase\Bundle\ExerciseBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;

class ExerciseUserReminderRepository extends EntityRepository
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

        return $queryBuilder->getQuery()->getResult();
    }
}
