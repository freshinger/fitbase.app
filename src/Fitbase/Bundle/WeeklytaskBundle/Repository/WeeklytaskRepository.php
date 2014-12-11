<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch;

class WeeklytaskRepository extends EntityRepository
{
    /**
     *
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprPriorityNotNull($queryBuilder)
    {
        return $queryBuilder->expr()->isNotNull('Weeklytask.priority');
    }


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
                $queryBuilder->expr()->like('Weeklytask.name', ':string'),
                $queryBuilder->expr()->like('Weeklytask.category', ':string')
            );
        }

        return $queryBuilder->expr()->eq('1', '1');
    }

    /**
     * Get expr by category
     * @param $queryBuilder
     * @param $string
     * @return mixed
     */
    protected function getExprCategory($queryBuilder, $string)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter('category', $string);
            return $queryBuilder->expr()->eq('Weeklytask.category', ':category');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find record by week id
     * @param $queryBuilder
     * @param $weekId
     * @return mixed
     */
    protected function getExprWeekId($queryBuilder, $weekId)
    {
        if (!empty($weekId)) {
            $queryBuilder->setParameter('weekId', $weekId);
            return $queryBuilder->expr()->eq('Weeklytask.weekId', ':weekId');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find record by user id
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprNotUser($queryBuilder, $user)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->orX(
                $queryBuilder->expr()->isNull('WeeklytaskUser.user'),
                $queryBuilder->expr()->neq('WeeklytaskUser.user', ':user')
            );
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     *
     * @param $queryBuilder
     * @param $datetime
     * @return mixed
     */
    protected function getExprNotDateTime($queryBuilder, $datetime)
    {
        if (!empty($datetime)) {
            $queryBuilder->setParameter('datetime', $datetime);
            return $queryBuilder->expr()->orX(
                $queryBuilder->expr()->isNull('WeeklytaskUser.date'),
                $queryBuilder->expr()->gt('WeeklytaskUser.date', ':datetime')
            );
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Find one weekly task by week id
     * @param $weekId
     * @return mixed
     */
    public function findOneByWeekId($weekId)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklytask');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprWeekId($queryBuilder, $weekId)
        ));

        $queryBuilder->orderBy('Weeklytask.id', 'DESC');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Find count of weeklytasks by category
     * @param $string
     * @return mixed
     */
    public function findCountByCategory($string)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklytask');
        $queryBuilder->select('COUNT(Weeklytask)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCategory($queryBuilder, $string)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Return array with categories
     * @return array
     */
    public function findAllCategory()
    {
        $queryBuilder = $this->createQueryBuilder('Weeklytask');

        $queryBuilder->groupBy('Weeklytask.category');

        $result = array();
        if (($collection = $queryBuilder->getQuery()->getResult())) {
            foreach ($collection as $weeklytask) {
                array_push($result, $weeklytask->getCategory());
            }
        }
        return $result;
    }

    /**
     * Get query builder for weeklytask list
     * @param $weeklytaskSearch
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder(WeeklytaskSearch $weeklytaskSearch)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklytask');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprString($queryBuilder, $weeklytaskSearch->getString())
        ));

        $associationOrder = array(
            'name' => 'Weeklytask.name',
            'category' => 'Weeklytask.category',
            'weekId' => 'Weeklytask.weekId',
            'postId' => 'Weeklytask.postId',
            'quizId' => 'Weeklytask.quizId',
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
        $queryBuilder = $this->createQueryBuilder('Weeklytask');
        $queryBuilder->select('COUNT(Weeklytask)');

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * @param $category
     * @return array
     */
    public function findByCategory($category)
    {
        $queryBuilder = $this->createQueryBuilder("Weeklytask")
            ->where(':category MEMBER OF Weeklytask.categories')
            ->setParameters(array('category' => $category));

        $queryBuilder->addOrderBy('Weeklytask.priority', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Find all categories by priority
     * @param $user
     * @param $category
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAllByCategoryAndPriority($category)
    {
        $queryBuilder = $this->createQueryBuilder('Weeklytask');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCategory($queryBuilder, $category),
            $this->getExprPriorityNotNull($queryBuilder)
        ));

        $queryBuilder->addOrderBy('Weeklytask.priority', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all categories by priority
     * @param $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAllByPriority()
    {
        $queryBuilder = $this->createQueryBuilder('Weeklytask');

        $queryBuilder->where($queryBuilder->expr()->orX(
            $this->getExprPriorityNotNull($queryBuilder)
        ));

        $queryBuilder->addOrderBy('Weeklytask.priority', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
}
