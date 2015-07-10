<?php

namespace Fitbase\Bundle\ReminderBundle\Repository;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;

class ReminderUserRepository extends ReminderUserRepositoryAbstract
{
    /**
     * Get expression to find records by enable weekly quiz sending
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprSendWeeklyquiz($queryBuilder)
    {
        $queryBuilder->setParameter(':sendWeeklyquiz', 1);
        return $queryBuilder->expr()->eq('ReminderUser.sendWeeklyquiz', ':sendWeeklyquiz');
    }

    /**
     * Get expression to find records by enabled weekly task sending
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprSendWeeklytask($queryBuilder)
    {
        $queryBuilder->setParameter(':sendWeeklytask', 1);
        return $queryBuilder->expr()->eq('ReminderUser.sendWeeklytask', ':sendWeeklytask');
    }

    /**
     * Get all not paused reminders
     * @return array
     */
    public function findAllByNotPause()
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');
        $queryBuilder->join('ReminderUser.user', 'User');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotPaused($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all not paused records enabled to send weekly quiz
     * @return array
     */
    public function findAllByNotPauseAndSendWeeklyquiz()
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');
        $queryBuilder->join('ReminderUser.user', 'User');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotPaused($queryBuilder),
            $this->getExprSendWeeklyquiz($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all not paused records with enabled weekly task sending
     * @return array
     */
    public function findAllByNotPauseAndSendWeeklytask()
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');
        $queryBuilder->join('ReminderUser.user', 'User');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotPaused($queryBuilder),
            $this->getExprSendWeeklytask($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Get all paused reminder
     * @return array
     */
    public function findAllByPause()
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');
        $queryBuilder->join('ReminderUser.user', 'User');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprPaused($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Find reminder by user
     * @param $user
     * @return mixed
     */
    public function findOneByUser($user = null)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');
        $queryBuilder->join('ReminderUser.user', 'User');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->setMaxResults(1)
            ->addOrderBy('ReminderUser.id', 'DESC');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find all paused by date
     *
     * @param $date
     * @return array
     */
    public function findPausedByDate($date)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');
        $queryBuilder->join('ReminderUser.user', 'User');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprPaused($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }
}
