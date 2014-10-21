<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GamificationDialogQuestionRepository extends EntityRepository
{
    /**
     * Find records by start
     * @param $queryBuilder
     * @return mixed
     */
    public function getExprStart($queryBuilder)
    {
        $queryBuilder->setParameter('start', 1);
        return $queryBuilder->expr()->eq('GamificationDialogQuestion.start', ':start');
    }

    /**
     * Find one record by start
     */
    public function findOneByStart()
    {
        $queryBuilder = $this->createQueryBuilder('GamificationDialogQuestion');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprStart($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Get query builder to draw a list
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder()
    {
        $queryBuilder = $this->createQueryBuilder('GamificationDialogQuestion');

        $queryBuilder->orderBy('GamificationDialogQuestion.id', 'DESC');

        return $queryBuilder;
    }
}