<?php

namespace Fitbase\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;

class UserSingleSignOnRepository extends EntityRepository
{
    /**
     * Get all user-tasks
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter(':user', $user->getId());
            return $queryBuilder->expr()->eq('ReminderUser.user', ':user');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * @param $queryBuilder
     * @param $code
     * @return mixed
     */
    protected function getExprCode($queryBuilder, $code)
    {
        if (!empty($code)) {
            $queryBuilder->setParameter(':code', $code);
            return $queryBuilder->expr()->eq('UserSingleSignOn.code', ':code');
        }
        return $queryBuilder->expr()->eq('1', '0');
    }

    /**
     * Get expr for all not paused reminders
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', 0);
        return $queryBuilder->expr()->orx(
            $queryBuilder->expr()->isNull('UserSingleSignOn.processed'),
            $queryBuilder->expr()->eq('UserSingleSignOn.processed', ':processed')
        );
    }
//
//
//    public function findAllByNotPause()
//    {
//        $queryBuilder = $this->createQueryBuilder('ReminderUser');
//        $queryBuilder->where($queryBuilder->expr()->andX(
//            $this->getExprNotPaused($queryBuilder)
//        ));
//
//        return $queryBuilder->getQuery()->getResult();
//    }

//    /**
//     * Find reminder by user
//     * @param $user
//     * @return mixed
//     */
//    public function findOneByUser($user = null)
//    {
//        $queryBuilder = $this->createQueryBuilder('ReminderUser');
//
//        $queryBuilder->where($queryBuilder->expr()->andX(
//            $this->getExprUser($queryBuilder, $user)
//        ));
//
//        $queryBuilder->setMaxResults(1)
//            ->addOrderBy('ReminderUser.id', 'DESC');
//
//        return $queryBuilder->getQuery()->getOneOrNullResult();
//    }


    public function findOneByCodeAndNotProcessed($code = null)
    {
        $queryBuilder = $this->createQueryBuilder('UserSingleSignOn');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCode($queryBuilder, $code),
            $this->getExprNotProcessed($queryBuilder)
        ));


        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


}
