<?php

namespace Fitbase\Bundle\KnowledgeBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * KnowledgeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KnowledgeRepository extends EntityRepository
{
    /**
     * Get expression by knowledge
     * @param $queryBuilder
     * @param $knowledge
     * @return mixed
     */
    protected function getExprNext($queryBuilder, $knowledge)
    {
        if (!empty($knowledge)) {
            $queryBuilder->setParameter('id', $knowledge->getId());
            return $queryBuilder->expr()->gt('Knowledge.id', ':id');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findFirst()
    {
        $queryBuilder = $this->createQueryBuilder('Knowledge');

        $queryBuilder->orderBy('Knowledge.id', 'ASC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Find next knowledge
     *
     * @param $knowledge
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findNext($knowledge)
    {
        $queryBuilder = $this->createQueryBuilder('Knowledge');
        $queryBuilder->andWhere($queryBuilder->expr()->andX(
            $this->getExprNext($queryBuilder, $knowledge)
        ));

        $queryBuilder->orderBy('Knowledge.id', 'ASC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


}