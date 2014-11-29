<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 2:15 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ReminderUserItemRepository extends EntityRepository
{
    /**
     * Get expression to find element by id
     * @param $queryBuilder
     * @param $id
     * @return mixed
     */
    protected function getExprId($queryBuilder, $id)
    {
        if (!empty($id)) {
            $queryBuilder->setParameter('id', $id);
            return $queryBuilder->expr()->eq('ReminderUserItem.id', ':id');
        }
        return $queryBuilder->expr()->eq('1', '0');
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
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('ReminderUserItem.user', ':user');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }


    /**
     * Get all user-tasks
     * @param $queryBuilder
     * @param $reminder
     * @return mixed
     */
    protected function getExprReminder($queryBuilder, $reminder)
    {
        if (!empty($reminder)) {
            $queryBuilder->setParameter('reminder', $reminder->getId());
            return $queryBuilder->expr()->eq('ReminderUserItem.reminder', ':reminder');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     *
     * @param $queryBuilder
     * @param $type
     * @return mixed
     */
    protected function getExprType($queryBuilder, $type)
    {
        if (strlen($type)) {
            $queryBuilder->setParameter('type', $type);
            return $queryBuilder->expr()->eq('ReminderUserItem.type', ':type');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     *
     * @param $queryBuilder
     * @param $dayId
     * @return mixed
     */
    public function getExprDay($queryBuilder, $dayId)
    {
        if (!empty($dayId)) {
            $queryBuilder->setParameter('dayId', $dayId);
            return $queryBuilder->expr()->eq('ReminderUserItem.day', ':dayId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * Expression to get items for not paused reminders
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotPaused($queryBuilder)
    {
        $queryBuilder->setParameter(':pause', 0);
        return $queryBuilder->expr()->orx(
            $queryBuilder->expr()->isNull('ReminderUser.pause'),
            $queryBuilder->expr()->eq('ReminderUser.pause', ':pause')
        );
    }

    /**
     * Get reminder items by user
     * @param $user
     * @return array
     */
    public function findAllByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserItem');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->orderBy('ReminderUserItem.day', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get reminder items by reminder object
     * @param $reminder
     * @return array
     */
    public function findAllByReminder($reminder)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserItem');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprReminder($queryBuilder, $reminder)
        ));

        $queryBuilder->orderBy('ReminderUserItem.day', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     *
     * @param $reminder
     * @param $type
     * @return array
     */
    public function findAllByReminderAndType($reminder, $type)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserItem');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprReminder($queryBuilder, $reminder),
            $this->getExprType($queryBuilder, $type)
        ));

        $queryBuilder->orderBy('ReminderUserItem.day', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find Reminder item by user and id
     * @param $user
     * @param $id
     * @return mixed
     */
    public function findOneByUserAndId($user, $id)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserItem');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprId($queryBuilder, $id),
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find reminder items by day and reminder
     * @param $reminder
     * @param $day
     * @return array
     */
    public function findAllByReminderAndDay($reminder, $day)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserItem');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprReminder($queryBuilder, $reminder),
            $this->getExprDay($queryBuilder, $day)
        ));

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Find all item-records for not paused reminders
     * @param $day
     * @return array
     */
    public function findAllNotPausedByDayAndType($day = null, $type = null)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUserItem');
        $queryBuilder->leftJoin('ReminderUserItem.reminder', 'ReminderUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprDay($queryBuilder, $day),
            $this->getExprType($queryBuilder, $type),
            $this->getExprNotPaused($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }
}