<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/9/14
 * Time: 11:21 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\UserBundle\Entity\UserSearch;

class UserStatisticRepository extends EntityRepository
{
    /**
     * @param $queryBuilder
     * @param $string
     */
    protected function getExprUserName($queryBuilder, $string)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter(':name', "%$string%");
            return $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('User.nicename', ":name"),
                $queryBuilder->expr()->like('User.displayName', ":name"),
                $queryBuilder->expr()->like('User.login', ":name")
            );
        }
        return $queryBuilder->expr()->eq('1', '1');
    }

    /**
     * @param $queryBuilder
     * @param $string
     */
    protected function getExprUserEmail($queryBuilder, $string)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter(':email', "%$string%");
            return $queryBuilder->expr()->like('User.email', ":email");
        }
        return $queryBuilder->expr()->eq('1', '1');
    }

    /**
     * Find user by user agent
     * @param $queryBuilder
     * @param $string
     * @return mixed
     */
    protected function getExprUserAgent($queryBuilder, $string)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter(':userAgent', "%$string%");
            return $queryBuilder->expr()->like('UserStatistic.userAgent', ":userAgent");
        }
        return $queryBuilder->expr()->eq('1', '1');
    }

    /**
     * Find user by user role
     * @param $queryBuilder
     * @param $string
     * @return mixed
     */
    protected function getExprUserRole($queryBuilder, $string)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter(':key', 'ors_capabilities');
            $queryBuilder->setParameter(':value', "%$string%");
            return $queryBuilder->expr()->andX(
                $queryBuilder->expr()->like('UserMeta.key', ":key"),
                $queryBuilder->expr()->like('UserMeta.value', ":value")
            );
        }
        return $queryBuilder->expr()->eq('1', '1');
    }


    /**
     * Get query builder for user list
     * @param UserSearch $entity
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilderUserStatistic(UserSearch $entity)
    {
        $queryBuilder = $this->createQueryBuilder('UserStatistic')
            ->join('UserStatistic.user', 'User')
            ->join('User.metas', 'UserMeta');

        $queryBuilder->where($queryBuilder->expr()->orX(
            $this->getExprUserEmail($queryBuilder, $entity->getString()),
            $this->getExprUserName($queryBuilder, $entity->getString()),
            $this->getExprUserAgent($queryBuilder, $entity->getString()),
            $this->getExprUserRole($queryBuilder, $entity->getString())
        ));

        $orderList = array(
            'id' => 'UserStatistic.id',
            'videos' => 'UserStatistic.countVideo',
            'logins' => 'UserStatistic.countLogin',
            'weeklytasks' => 'UserStatistic.countWeeklyTask',
            'registeredAt' => 'User.registered',
            'loggedAt' => 'UserStatistic.loggedAt',
        );

        if (isset($orderList[$entity->getOrder()])) {
            if (($oder = $orderList[$entity->getOrder()])) {
                $queryBuilder->orderBy($oder, $entity->getBy());
            }
        }

        return $queryBuilder;
    }
}