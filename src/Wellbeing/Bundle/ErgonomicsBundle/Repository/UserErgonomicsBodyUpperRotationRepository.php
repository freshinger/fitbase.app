<?php
namespace Wellbeing\Bundle\ErgonomicsBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class UserErgonomicsBodyUpperRotationRepository extends EntityRepository
{

    /**
     * Get expression by user
     *
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('UserErgonomics.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get average
     *
     * @param $user
     * @param int $minimum
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return float
     */
    public function findAverage($user, $minimum = 100)
    {
        $queryBuilder = $this->createQueryBuilder("UserErgonomicsBodyUpperRotation");
        $queryBuilder->leftJoin('UserErgonomicsBodyUpperRotation.ergonomics', 'UserErgonomics');
        $queryBuilder->select('SUM(UserErgonomicsBodyUpperRotation.angle)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        $summ = $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);

        if (($count = $this->findCount($user)) > $minimum) {
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
        $queryBuilder = $this->createQueryBuilder("UserErgonomicsBodyUpperRotation");
        $queryBuilder->leftJoin('UserErgonomicsBodyUpperRotation.ergonomics', 'UserErgonomics');
        $queryBuilder->select('COUNT(UserErgonomicsBodyUpperRotation.angle)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Find all by user
     *
     * @todo add date limit for current day
     * @param $user
     * @return array
     */
    public function findByUser($user, $datetime = null)
    {
        $queryBuilder = $this->createQueryBuilder("UserErgonomicsBodyUpperRotation");
        $queryBuilder->leftJoin('UserErgonomicsBodyUpperRotation.ergonomics', 'UserErgonomics');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        return $queryBuilder->getQuery()->getResult();

    }


} 