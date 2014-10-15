<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class WeeklyquizRepository extends EntityRepository
{
    /**
     * Get expression to find records by string
     * @param $queryBuilder
     * @param $string
     * @return mixed
     */
    protected function getExprString($queryBuilder, $string)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter('string', '%' . $string . '%');
            return $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('Weeklyquiz.name', ':string'),
                $queryBuilder->expr()->like('Weeklyquiz.description', ':string')
            );
        }

        return $queryBuilder->expr()->eq('1', '1');
    }

    /**
     * Get expression to find by weekly task
     * @param $queryBuilder
     * @param $weeklytask
     * @return mixed
     */
    public function getExprWeeklytask($queryBuilder, $weeklytask)
    {
        if ($weeklytask == null) {
            return $queryBuilder->expr()->isNull('Weeklyquiz.weeklytaskId');
        }

        $queryBuilder->setParameter('weeklytaskId', $weeklytask->getId());
        return $queryBuilder->expr()->eq('Weeklyquiz.weeklytaskId', ':weeklytaskId');
    }

    /**
     * Get expression to find record by weeklytask id
     * @param $queryBuilder
     * @param $weeklytaskId
     * @return mixed
     */
    public function getExprWeeklytaskId($queryBuilder, $weeklytaskId)
    {
        if (!empty($weeklytaskId)) {
            $queryBuilder->setParameter('weeklytaskId', $weeklytaskId);
            return $queryBuilder->expr()->eq('Weeklyquiz.weeklytaskId', ':weeklytaskId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find all records by weekly task
     * @param null $weeklytask
     * @return array
     */
    public function findAllByWeeklytask($weeklytask = null)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklyquiz');


        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprWeeklytask($queryBuilder, $weeklytask)
        ));

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Find weeklytask quiz
     * @param $weeklytaskId
     * @return mixed
     */
    public function findOneByWeeklytaskId($weeklytaskId)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklyquiz');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprWeeklytaskId($queryBuilder, $weeklytaskId)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Get query builder for weeklytask list
     * @param $weeklytaskSearch
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder(WeeklytaskSearch $weeklytaskSearch)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklyquiz');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprString($queryBuilder, $weeklytaskSearch->getString())
        ));

        $associationOrder = array(
            'id' => 'Weeklyquiz.id',
            'name' => 'Weeklyquiz.name',
            'weeklytaskIdId' => 'Weeklyquiz.weeklytaskIdId',
        );

        $associationBy = array(
            'asc' => 'ASC',
            'desc' => 'DESC'
        );

        if (($order = $weeklytaskSearch->getOrder()) and ($by = $weeklytaskSearch->getBy())) {
            if (isset($associationOrder[$order]) and isset($associationBy[$by])) {
                $queryBuilder->orderBy($associationOrder[$order], $associationBy[$by]);
            }
        }

        return $queryBuilder;
    }


    /**
     * Find weeklytask count
     * @return mixed
     */
    public function findCount()
    {
        $queryBuilder = $this->createQueryBuilder('Weeklyquiz');
        $queryBuilder->select('COUNT(Weeklyquiz)');

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
