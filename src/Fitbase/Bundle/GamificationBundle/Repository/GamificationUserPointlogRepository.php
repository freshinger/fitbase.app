<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GamificationUserPointlogRepository extends EntityRepository
{
    /**
     * Get expression to find record by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    public function getExprUserId($queryBuilder, $userId)
    {
        if (!empty($userId)) {

            $queryBuilder->setParameter('userId', $userId);
            return $queryBuilder->expr()->eq('GamificationUserPointlog.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * TODO: refactoring to speed-up
     * @param array $arrayUser
     * @return mixed
     */
    public function findAllByUserIdArray($arrayUser = array())
    {
        $result = array();
        foreach ($arrayUser as $user) {
            array_push($result, $this->findOneLastByUser($user));
        }
        return $result;
    }

    /**
     * Find last record by user
     * @param $user
     * @return mixed
     */
    public function findOneLastByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('GamificationUserPointlog');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserId($queryBuilder, $user->getId())
        ));

        $queryBuilder->addOrderBy('GamificationUserPointlog.id', 'DESC');
        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Get user point statistic
     * @param null $user
     * @param \DateTime $date
     * @return array
     */
    public function findAllByUserGroupByWeek($user = null, \DateTime $date)
    {
        if (!empty($user)) {

            $connection = $this->getEntityManager()->getConnection();

            $query = $connection->prepare("SELECT
                  ors_gamification_user_pointlog.date as date,
                  ors_gamification_user_pointlog.count_point_total as count_point_total
                  FROM ors_gamification_user_pointlog
                  WHERE ors_gamification_user_pointlog.user_id=:user_id
                  AND ors_gamification_user_pointlog.date > DATE(:date)
                  GROUP BY WEEK(date)");

            $query->execute(array(
                'user_id' => $user->getId(),
                'date' => $date->format('Y-m-d'),
            ));

            return $query->fetchAll();
        }

        return array();
    }

}