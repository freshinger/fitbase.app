<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GamificationUserDialogFeedbackRepository extends EntityRepository
{
    /**
     * find records by positive
     * @param $queryBuilder
     * @return mixed
     */
    public function getExprPositive($queryBuilder)
    {
        $queryBuilder->setParameter('positive', 1);
        return $queryBuilder->expr()->eq('GamificationDialogQuestion.positive', ':positive');
    }

    /**
     * Get expression to find record by user id
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    public function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {

            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('GamificationUserDialogFeedback.user', ':user');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $user
     * @return mixed
     */
    public function findTextRandomByUserAndPositive($user)
    {
        $queryBuilder = $this->createQueryBuilder('GamificationUserDialogFeedback');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $queryBuilder->addOrderBy('GamificationUserDialogFeedback.id', 'DESC');
        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}