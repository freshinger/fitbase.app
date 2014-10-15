<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class WeeklyquizUserRepository extends EntityRepository
{
    /**
     * Get expression to find record by userF
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    public function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {

            $queryBuilder->setParameter('userId', $user->getId());
            return $queryBuilder->expr()->eq('WeeklyquizUser.userId', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find record by code
     * @param $queryBuilder
     * @param $code
     * @return mixed
     */
    protected function getExprCode($queryBuilder, $code)
    {
        if (!empty($code)) {

            $queryBuilder->setParameter('code', $code);
            return $queryBuilder->expr()->eq('WeeklyquizUser.code', ':code');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get all not done tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotDone($queryBuilder)
    {
        $queryBuilder->setParameter(':done', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('WeeklyquizUser.done', ':done'),
            $queryBuilder->expr()->isNull('WeeklyquizUser.done')
        );
    }

    /**
     * Find record by quiz id
     * @param $queryBuilder
     * @param $quizId
     * @return mixed
     */
    protected function getExprQuizId($queryBuilder, $quizId)
    {
        if (!empty($quizId)) {

            $queryBuilder->setParameter('quizId', $quizId);
            return $queryBuilder->expr()->eq('WeeklyquizUser.quizId', ':quizId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Get expression to find records by company id
     * @param $queryBuilder
     * @param $company
     * @return mixed
     */
    protected function getExprCompany($queryBuilder, $company)
    {
        if (!empty($company)) {

            $queryBuilder->setParameter('metaKey', 'user_company_id');
            $queryBuilder->setParameter('metaValue', $company->getId());

            return $queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq('UserMeta.key', ':metaKey'),
                $queryBuilder->expr()->eq('UserMeta.value', ':metaValue')
            );
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find records by weekly task id
     * @param $queryBuilder
     * @param $weeklytaskId
     * @return mixed
     */
    protected function getExprWeeklytaskId($queryBuilder, $weeklytaskId)
    {
        if (!empty($weeklytaskId)) {

            $queryBuilder->setParameter('weeklytaskId', $weeklytaskId);
            return $queryBuilder->expr()->eq('WeeklyquizUser.weeklytaskId', ':weeklytaskId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find one record by user and code
     * @param $user
     * @param $code
     * @return mixed
     */
    public function findOneByUserAndCode($user, $code)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprCode($queryBuilder, $code)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one record by user and code
     * @param $user
     * @param $code
     * @return mixed
     */
    public function findOneByUserAndCodeAndNotDone($user, $code)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprCode($queryBuilder, $code),
            $this->getExprNotDone($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one record by user and quiz id
     * @param $user
     * @param $quizId
     * @return mixed
     */
    public function findOneByUserAndQuizId($user, $quizId)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprQuizId($queryBuilder, $quizId)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one record by weekly task id and user
     * @param $user
     * @param $weeklytaskId
     * @return mixed
     */
    public function findOneByUserAndWeeklytaskId($user, $weeklytaskId)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprWeeklytaskId($queryBuilder, $weeklytaskId)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Get records by quiz
     * @param $quiz
     * @return array
     */
    public function findAllByWeeklyquiz($quiz)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuizId($queryBuilder, $quiz->getId())
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find count of weeklytasks by company
     * @param $company
     * @return mixed
     */
    public function findCountByCompany($company)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->leftJoin('WeeklyquizUser.user', 'User');
        $queryBuilder->leftJoin('User.metas', 'UserMeta');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company)
        ));

        $queryBuilder->groupBy('WeeklyquizUser.quizId');

        if (($result = $queryBuilder->getQuery()->getResult())) {
            return count($result);
        }

        return 0;
    }

}
