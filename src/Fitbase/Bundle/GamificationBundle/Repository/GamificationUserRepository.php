<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GamificationUserRepository extends EntityRepository
{
    /**
     * Get expression to find record by user id
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    public function getExprUser($queryBuilder, $user)
    {
        if (is_object($user)) {

            $queryBuilder->setParameter('userId', $user->getId());
            return $queryBuilder->expr()->eq('GamificationUser.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get one record by user
     * @param $user
     * @return mixed
     */
    public function findOneByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('GamificationUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}