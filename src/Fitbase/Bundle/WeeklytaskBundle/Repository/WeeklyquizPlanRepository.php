<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch;

class WeeklyquizPlanRepository extends EntityRepository
{
    /**
     * Get all not done tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('WeeklyquizPlan.processed', ':processed'),
            $queryBuilder->expr()->isNull('WeeklyquizPlan.processed')
        );
    }

    /**
     * Get expression to find all processed tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprProcessed($queryBuilder)
    {
        $queryBuilder->setParameter('processed', 1);
        return $queryBuilder->expr()->eq('WeeklyquizPlan.processed', ':processed');
    }

    /**
     * Get all user-tasks
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter(':userId', $user->getId());
            return $queryBuilder->expr()->eq('WeeklyquizPlan.userId', ':userId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * Get expression to find element by max date
     * @param $queryBuilder
     * @param $date
     * @return mixed
     */
    protected function getExprMaxDate($queryBuilder, $date)
    {
        if (!empty($date)) {
            $queryBuilder->setParameter(':date', $date);
            return $queryBuilder->expr()->lte('WeeklyquizPlan.date', ':date');
        }

        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * Get expression to find record by week id
     * @param $queryBuilder
     * @param $weekId
     * @return mixed
     */
    protected function getExprWeekId($queryBuilder, $weekId)
    {
        if (!empty($weekId)) {
            $queryBuilder->setParameter(':weekId', $weekId);
            return $queryBuilder->expr()->eq('WeeklyquizPlan.weekId', ':weekId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * Get expression to find record by quiz id
     * @param $queryBuilder
     * @param $quizId
     * @return mixed
     */
    protected function getExprQuizId($queryBuilder, $quizId)
    {
        if (!empty($quizId)) {
            $queryBuilder->setParameter('quizId', $quizId);
            return $queryBuilder->expr()->eq('WeeklyquizPlan.quizId', ':quizId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * @param Weeklyquiz $weeklytaskQuiz
     * @return mixed
     */
    public function findAllByWeeklyquiz(Weeklyquiz $weeklytaskQuiz)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuizId($queryBuilder, $weeklytaskQuiz->getId())
        ));
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find one record by user object and week id
     * @param $user
     * @param $weekId
     * @return mixed
     */
    public function findOneByUserAndWeekId($user, $weekId)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprWeekId($queryBuilder, $weekId),
            $this->getExprUser($queryBuilder, $user)
        ));
        $queryBuilder->orderBy('WeeklyquizPlan.id', 'DESC');
        $queryBuilder->setMaxResults(1);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find not processed element till given date
     * @param $user
     * @param $date
     * @return array
     */
    public function findAllByUserAndDateAndNotProcessed($user, $date)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprMaxDate($queryBuilder, $date),
            $this->getExprNotProcessed($queryBuilder),
            $this->getExprUser($queryBuilder, $user)
        ));
        $queryBuilder->orderBy('WeeklyquizPlan.id', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find last processed task
     * @param $user
     * @return mixed
     */
    public function findOneLastByProcessedAndUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprProcessed($queryBuilder),
            $this->getExprUser($queryBuilder, $user)
        ));
        $queryBuilder->orderBy('WeeklyquizPlan.id', 'DESC');
        $queryBuilder->setMaxResults(1);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Get query builder for weeklytask list
     * @param $weeklytaskSearch
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllNotProcessedQueryBuilder(WeeklytaskSearch $weeklytaskSearch = null)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizPlan');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotProcessed($queryBuilder)
        ));

        return $queryBuilder;
    }

    /**
     * Get quiery builder predefined for processed elements
     * @param WeeklytaskSearch $weeklytaskSearch
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllProcessedQueryBuilder(WeeklytaskSearch $weeklytaskSearch = null)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizPlan');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprProcessed($queryBuilder)
        ));

        return $queryBuilder;
    }

}
