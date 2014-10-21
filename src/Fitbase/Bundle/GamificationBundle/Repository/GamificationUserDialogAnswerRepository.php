<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GamificationUserDialogAnswerRepository extends EntityRepository
{

    /**
     * Show records where hidden ist false or null
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotHidden($queryBuilder)
    {
        $queryBuilder->setParameter(':hidden', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('GamificationUserDialogAnswer.hidden', ':hidden'),
            $queryBuilder->expr()->isNull('GamificationUserDialogAnswer.hidden')
        );
    }

    /**
     * Get expression to find element by max date
     * @param $queryBuilder
     * @param $date
     * @return mixed
     */
    protected function getExprDate($queryBuilder, $date)
    {
        if (!empty($date)) {
            $queryBuilder->setParameter('date', $date->setTime(0, 0, 0));
            return $queryBuilder->expr()->eq('GamificationUserDialogAnswer.date', ':date');
        }

        return $queryBuilder->expr()->eq('1', '0');
    }

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
            return $queryBuilder->expr()->eq('GamificationUserDialogAnswer.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get all records by user and date
     * @param $user
     * @param $datetime
     * @return array
     */
    public function findAllByUserAndDate($user, $datetime)
    {
        $queryBuilder = $this->createQueryBuilder('GamificationUserDialogAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserId($queryBuilder, $user->getId()),
            $this->getExprNotHidden($queryBuilder),
            $this->getExprDate($queryBuilder, $datetime)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

}