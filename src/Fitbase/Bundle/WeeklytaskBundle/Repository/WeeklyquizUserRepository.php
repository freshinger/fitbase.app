<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;

class WeeklyquizUserRepository extends EntityRepository
{
    protected function getExprUnique($queryBuilder, $unique = null)
    {
        if (!empty($unique)) {
            $queryBuilder->setParameter('unique', $unique);
            return $queryBuilder->expr()->eq('WeeklyquizUser.id', ':unique');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * @param $queryBuilder
     * @param null $unique
     * @return mixed
     */
    protected function getExprNotUnique($queryBuilder, $unique = null)
    {
        if (!is_null($unique)) {
            $queryBuilder->setParameter('not_unique', $unique);
            return $queryBuilder->expr()->neq('WeeklyquizUser.id', ':not_unique');
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
            $queryBuilder->setParameter('datetime', $datetime);
            return $queryBuilder->expr()->lt('WeeklyquizUser.date', ':datetime');
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
            return $queryBuilder->expr()->eq('WeeklyquizUser.date', ':datetime');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }





    /**
     * Get all not processed tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', true);
        return $queryBuilder->expr()->eq('WeeklyquizUser.processed', ':processed');
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
            $queryBuilder->expr()->eq('WeeklyquizUser.processed', ':processed'),
            $queryBuilder->expr()->isNull('WeeklyquizUser.processed')
        );
    }

    /**
     * Get expression to find record by userF
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    public function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {

            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('WeeklyquizUser.user', ':user');
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
     * @deprecated
     * @todo replace to getExprQuiz
     * @param $quizId
     * @return mixed
     */
    protected function getExprQuizId($queryBuilder, $quizId)
    {
        if (!empty($quizId)) {

            $queryBuilder->setParameter('quiz', $quizId);
            return $queryBuilder->expr()->eq('WeeklyquizUser.quiz', ':quiz');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find record by quiz id
     * @param $queryBuilder
     * @param $quiz
     * @return mixed
     */
    protected function getExprQuiz($queryBuilder, Weeklyquiz $quiz = null)
    {
        if (!empty($quiz)) {

            $queryBuilder->setParameter('quiz', $quiz->getId());
            return $queryBuilder->expr()->eq('WeeklyquizUser.quiz', ':quiz');
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
     * @param $task
     * @return mixed
     */
    protected function getExprWeeklytask($queryBuilder, $task)
    {
        if (!empty($task)) {

            $queryBuilder->setParameter('task', $task->getId());
            return $queryBuilder->expr()->eq('WeeklyquizUser.task', ':task');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get all not done tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprDone($queryBuilder)
    {
        $queryBuilder->setParameter('done', true);
        return $queryBuilder->expr()->eq('WeeklyquizUser.done', ':done');
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
     * Find weeklyquiz user object
     * @param $user
     * @param Weeklyquiz $weeklyquiz
     * @internal param WeeklytaskUser $weeklytaskUser
     * @return array
     */
    public function findOneByUserAndQuiz($user, Weeklyquiz $weeklyquiz = null)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprQuiz($queryBuilder, $weeklyquiz)
        ));
        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one record by user and quiz id
     * @param $user
     * @deprecated
     * @todo replace by findOneByUserAndQuiz
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
    public function findCountDoneByCompany($company)
    {
        $points = 0;
        if (($collection = $company->getUsers())) {
            foreach ($collection as $user) {
                if (($countQuiz = $this->findCountDoneByUser($user))) {
                    $points += $countQuiz;
                }
            }
        }
        return $points;
    }

    /**
     * @param $user
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCountDoneByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');
        $queryBuilder->select('COUNT(WeeklyquizUser)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDone($queryBuilder)
        ));

        return (int)$queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Get sum points
     * @param $user
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findSumPointByUserAndDone($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');
        $queryBuilder->select('SUM(WeeklyquizUser.countPoint)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDone($queryBuilder)
        ));

        return (int)$queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }


    /**
     * @param $user
     * @param $unique
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndUnique($user, $unique)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprUnique($queryBuilder, $unique)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find quizze by not processed and date
     * @param $datetime
     * @return array
     */
    public function findAllNotProcessedByDateTime($datetime)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprDateTimeLt($queryBuilder, $datetime),
            $this->getExprNotProcessed($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAllNotDoneByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprNotDone($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param WeeklytaskUser $entity
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function processed(WeeklyquizUser $entity)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotUnique($queryBuilder, $entity->getId()),
            $this->getExprUser($queryBuilder, $entity->getUser()),
            $this->getExprDateTime($queryBuilder, $entity->getDate()),
            $this->getExprProcessed($queryBuilder)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
