<?php

namespace Fitbase\Bundle\ReminderBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ReminderUserPlanRepository extends EntityRepository
{

    /**
     * Get expression by max date
     * @param $queryBuilder
     * @param $date
     * @return mixed
     */
    protected function getExprDate($queryBuilder, $date)
    {
        $queryBuilder->setParameter('dateMax', $date);
        return $queryBuilder->expr()->eq('ReminderUserPlan.date', ':dateMax');
    }

    /**
     * Get expression by max date
     * @param $queryBuilder
     * @param $date
     * @return mixed
     */
    protected function getExprDateMax($queryBuilder, $date)
    {
        $queryBuilder->setParameter('dateMax', $date);
        return $queryBuilder->expr()->lte('ReminderUserPlan.date', ':dateMax');
    }

    /**
     * Get expr for not processed plan
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotProcessed($queryBuilder)
    {
        $queryBuilder->setParameter('processed', false);
        return $queryBuilder->expr()->orx(
            $queryBuilder->expr()->isNull('ReminderUserPlan.processed'),
            $queryBuilder->expr()->eq('ReminderUserPlan.processed', ':processed')
        );
    }

    /**
     *
     * @param $queryBuilder
     * @param $user
     */
    protected function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('userId', $user->getId());
            return $queryBuilder->expr()->eq('ReminderUserPlan.userId', ':userId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     *
     * @param $queryBuilder
     * @param $reminder
     */
    protected function getExprReminder($queryBuilder, $reminder)
    {
        if (!empty($reminder)) {
            $queryBuilder->setParameter('reminderId', $reminder->getId());
            return $queryBuilder->expr()->eq('ReminderUserPlan.reminderId', ':reminderId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     *
     * @param $queryBuilder
     * @param $reminderItem
     * @return mixed
     */
    protected function getExprReminderItem($queryBuilder, $reminderItem)
    {
        if (!empty($reminderItem)) {
            $queryBuilder->setParameter('reminderItemId', $reminderItem->getId());
            return $queryBuilder->expr()->eq('ReminderUserPlan.reminderItemId', ':reminderItemId');
        }
        return $queryBuilder->expr()->eq('1', '0');

    }

    /**
     * Find plan record by reminder item
     * @param $reminderItem
     * @return mixed
     */
    public function findOneByReminderItemAndNotProcessed($reminderItem)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprReminderItem($queryBuilder, $reminderItem),
            $this->getExprNotProcessed($queryBuilder)
        ));

        $queryBuilder->setMaxResults(1)
            ->addOrderBy('ReminderUserPlan.id', 'DESC');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find plan record by reminder, user and reminder item
     * @param $user
     * @param $reminder
     * @param $datetime
     * @return mixed
     */
    public function findOneByUserAndReminderAndDate($user, $reminder, $datetime)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprReminder($queryBuilder, $reminder),
            $this->getExprDate($queryBuilder, $datetime)
        ));

        $queryBuilder->setMaxResults(1)
            ->addOrderBy('ReminderUserPlan.id', 'DESC');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Get list of current reminder plan list
     * @return array
     */
    public function findReminderPlanListCurrent()
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('ReminderUserPlan.processed', ':processed')
        ));

        $queryBuilder->setParameter("processed", false);
        $queryBuilder->orderBy('ReminderUserPlan.date', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get list with archived sent plans
     * @param $serviceDate
     * @return array
     */
    public function findReminderPlanArchiveList($serviceDate)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('ReminderUserPlan.processed', ':processed'),
            $queryBuilder->expr()->gte('ReminderUserPlan.date', ':date')
        ));

        $queryBuilder->setParameter("processed", true);
        $queryBuilder->setParameter("date", $serviceDate->getDateTime('now -14 days'));
        $queryBuilder->orderBy('ReminderUserPlan.date', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllProcessedQueryBuilder()
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('ReminderUserPlan.processed', ':processed')
        ));

        $queryBuilder->setParameter('processed', true);
        $queryBuilder->orderBy('ReminderUserPlan.date', 'DESC');

        return $queryBuilder;
    }


    /**
     * Find all reminder plans by reminder and date limit
     * @param $reminder
     * @param $date
     * @return array
     */
    public function findAllByReminderAndDayAndNotProcessed($reminder, $date)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprReminder($queryBuilder, $reminder),
            $this->getExprDateMax($queryBuilder, $date),
            $this->getExprNotProcessed($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Get list of plans to send
     * @param $serviceDate
     * @return array
     */
    public function findPlanListToSend($serviceDate)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserPlan');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('ReminderUserPlan.processed', ':processed'),
            $queryBuilder->expr()->lte('ReminderUserPlan.date', ':dateMax')
        ));
        $queryBuilder->setParameter("processed", false);

        $dateMax = $serviceDate->getDateTime('now');
        $dateMax->setTime($dateMax->format('H'), 59, 59);
        $queryBuilder->setParameter("dateMax", $dateMax);

        $queryBuilder->orderBy('ReminderUserPlan.id', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

}
