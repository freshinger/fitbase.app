<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/9/14
 * Time: 11:21 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class UserStatisticVideoRepository extends EntityRepository
{
    /**
     * Check existance of statistic record
     * @param UserVideoStatistic $entity
     * @return bool
     */
    public function getStatisticExists(UserVideoStatistic $entity)
    {
        $queryBuilder = $this->createQueryBuilder('UserStatisticVideo');
        $queryBuilder->select('COUNT(UserStatisticVideo)');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('UserStatisticVideo.pageId', ':pageId'),
            $queryBuilder->expr()->eq('UserStatisticVideo.userId', ':userId'),
            $queryBuilder->expr()->gte('UserStatisticVideo.date', ':date')
        ));

        $queryBuilder->setParameter('pageId', $entity->getPageId());
        $queryBuilder->setParameter('userId', $entity->getUserId());

        $date = clone $entity->getDate();
        $date->setTime(0, 0, 0);

        $queryBuilder->setParameter('date', $date);

        if ($queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR)) {
            return true;
        }
        return false;
    }


    /**
     * Get date of last viewed video
     * @param $userId
     * @return \DateTime
     */
    public function getUserViewDateLast($userId)
    {
        $queryBuilder = $this->createQueryBuilder('UserStatisticVideo');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('UserStatisticVideo.userId', ':userId')
        ));

        $queryBuilder->setParameter('userId', $userId);
        $queryBuilder->orderBy('UserStatisticVideo.date', 'DESC');
        $queryBuilder->setMaxResults(1);

        if (($statistic = $queryBuilder->getQuery()->getOneOrNullResult())) {
            return $statistic->getDate();
        }
        return null;
    }

    /**
     * Get count of viewed videos las week
     * @param $userId
     * @param $serviceDateTime
     * @return int
     */
    public function getUserViewCountLastWeek($userId, $serviceDateTime)
    {
        $queryBuilder = $this->createQueryBuilder('UserStatisticVideo');
        $queryBuilder->select('COUNT(UserStatisticVideo)');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('UserStatisticVideo.userId', ':userId'),
            $queryBuilder->expr()->gte('UserStatisticVideo.date', ':date')
        ));

        $queryBuilder->setParameter('userId', $userId);
        $queryBuilder->setParameter('date', $serviceDateTime->getDateTime('now -7 days'));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Get total count of viewed videos
     * @param $userId
     * @return mixed
     */
    public function getUserViewCountTotal($userId)
    {
        $queryBuilder = $this->createQueryBuilder('UserStatisticVideo');
        $queryBuilder->select('COUNT(UserStatisticVideo)');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('UserStatisticVideo.userId', ':userId')
        ));

        $queryBuilder->setParameter('userId', $userId);

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Fetch results by company
     * @param $company
     * @return array
     */
    public function findCountByCompanyForDate($company)
    {
        $sql = "SELECT sum(1) as count, video_statistic_date as date
                  FROM ors_user_video_statistics
                  JOIN ors_usermeta ON ors_usermeta.user_id=ors_user_video_statistics.video_statistic_user_id
                  WHERE ors_usermeta.meta_key=:meta_key
                  AND ors_usermeta.meta_value=:meta_value
                  GROUP BY MONTH(date)";

        $query = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);

        $query->execute(array(
            'meta_key' => 'user_company_id',
            'meta_value' => $company->getId()
        ));

        return $query->fetchAll();
    }
}