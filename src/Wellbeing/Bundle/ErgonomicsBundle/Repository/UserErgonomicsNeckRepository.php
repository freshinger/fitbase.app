<?php
namespace Wellbeing\Bundle\ErgonomicsBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class UserErgonomicsNeckRepository extends EntityRepository
{

    /**
     * Get expression by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('UserErgonomicsNeck.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Get average
     *
     * @param $user
     * @return float
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAverage($user)
    {
        $queryBuilder = $this->createQueryBuilder("UserErgonomicsNeck");
        $queryBuilder->select('SUM(UserErgonomicsNeck.angle)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $summ = $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);

        if (($count = $this->findCount($user)) > 100) {
            return $summ / $count;
        }
    }

    /**
     * Find count
     *
     * @param $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCount($user)
    {
        $queryBuilder = $this->createQueryBuilder("UserErgonomicsNeck");
        $queryBuilder->select('COUNT(UserErgonomicsNeck.angle)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }


} 