<?php

namespace Fitbase\Bundle\ReminderBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;

class ReminderUserRepository extends EntityRepository
{


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
            return $queryBuilder->expr()->eq('ReminderUser.userId', ':userId');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * Get expr by pause not null or empty
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprPaused($queryBuilder)
    {
        $queryBuilder->setParameter(':pause', 0);
        return $queryBuilder->expr()->andx(
            $queryBuilder->expr()->isNotNull('ReminderUser.pause'),
            $queryBuilder->expr()->gt('ReminderUser.pause', ':pause')
        );
    }

    /**
     * Get expr for all not paused reminders
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
    public function findOneByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('ReminderUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->setMaxResults(1)
            ->addOrderBy('ReminderUser.id', 'DESC');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Get list of plans to send
     * @param null $limit
     * @return array
     */
    public function findReminderListToPlan($limit = null)
    {
        $repositoryUser = $this->getEntityManager()
            ->getRepository('Ekino\WordpressBundle\Entity\User');

        $result = array();
        // TODO: refactoring, to speed-up and without requests
        foreach ($repositoryUser->findAll() as $user) {

            if ($user->getMetaValue('user_pause_start')) {
                continue;
            }

            $reminder = $this->findOneBy(array(
                'userId' => $user->getId()
            ));

            if ($reminder instanceof ReminderUser) {
                array_push($result, $reminder);
            }
        }

        return $result;
    }

}
