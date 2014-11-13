<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskSearch;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;

class WeeklytaskUserRepository extends EntityRepository
{
    /**
     * Get all not done tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotDone($queryBuilder)
    {
        $queryBuilder->setParameter(':done', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('WeeklytaskUser.done', ':done'),
            $queryBuilder->expr()->isNull('WeeklytaskUser.done')
        );
    }

    /**
     * Get all not done tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprDone($queryBuilder)
    {
        $queryBuilder->setParameter('done', true);
        return $queryBuilder->expr()->eq('WeeklytaskUser.done', ':done');
    }

    /**
     * Get expression to find records by user
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user)
    {
        if (is_object($user)) {
            return $this->getExprUserId($queryBuilder, $user->getId());
        }
        return null;
    }

    /**
     * @param $queryBuilder
     * @param $post
     * @return mixed
     */
    protected function getExprPost($queryBuilder, $post)
    {
        if (!empty($post)) {
            $queryBuilder->setParameter('postId', $post->getId());
            return $queryBuilder->expr()->eq('WeeklytaskUser.postId', ':postId');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    protected function getExprUserId($queryBuilder, $userId)
    {
        if (!empty($userId)) {
            $queryBuilder->setParameter('user', $userId);
            return $queryBuilder->expr()->eq('WeeklytaskUser.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expr by weeklytask id
     * @param $queryBuilder
     * @param $weeklytaskId
     * @return mixed
     */
    protected function getExprWeeklytaskId($queryBuilder, $weeklytaskId)
    {
        if (!empty($weeklytaskId)) {
            $queryBuilder->setParameter('task', $weeklytaskId);
            return $queryBuilder->expr()->eq('WeeklytaskUser.task', ':task');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find records by company id
     * @param $queryBuilder
     * @param $company
     * @return mixed
     */
    protected function getExprCompany($queryBuilder, $company)
    {
        if (!empty($company)) {

            $queryBuilder->setParameter('metaKey', 'user_company_id');
            $queryBuilder->setParameter('metaValue', $company->getId());

            return $queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq('UserMeta.key', ':metaKey'),
                $queryBuilder->expr()->eq('UserMeta.value', ':metaValue')
            );
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find one by weeklytask User object
     * @param WeeklytaskUser $weeklytaskUser
     * @return mixed
     */
    public function findOneByWeeklytaskUser(WeeklytaskUser $weeklytaskUser)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserId($queryBuilder, $weeklytaskUser->getUserId()),
            $this->getExprWeeklytaskId($queryBuilder, $weeklytaskUser->getWeeklytaskId())
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find all records by user
     * @param $user
     * @return array
     */
    public function findAllByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get list of records by user
     * @param $user
     * @return array
     */
    public function findAllByUserAndDone($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDone($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get not processed by user weekly tasks
     * @param $user
     * @return array
     */
    public function findAllByUserAndNotDone($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprNotDone($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find count of weeklytasks by company
     * @param $company
     * @return mixed
     */
    public function findCountByCompany($company)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');

        $queryBuilder->leftJoin('WeeklytaskUser.user', 'User');
        $queryBuilder->leftJoin('User.metas', 'UserMeta');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company)
        ));

        $queryBuilder->groupBy('WeeklytaskUser.weeklytaskId');

        if (($result = $queryBuilder->getQuery()->getResult())) {
            return count($result);
        }

        return 0;
    }

    /**
     * Find total user task count
     * @param $user
     * @return mixed
     */
    public function findCountByUser($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');
        $queryBuilder->select('COUNT(WeeklytaskUser)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Find count of processed by user tasks
     * @param $user
     * @return int
     */
    public function findCountByUserAndDone($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');
        $queryBuilder->select('COUNT(WeeklytaskUser)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDone($queryBuilder)
        ));

        return (int)$queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Find count of point of processed tasks
     * @param $user
     * @return int
     */
    public function findSumPointByUserAndDone($user)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');
        $queryBuilder->select('SUM(WeeklytaskUser.countPoint)');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprDone($queryBuilder)
        ));

        return (int)$queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Find
     * @param $user
     * @param $post
     * @return mixed
     */
    public function findOneByUserAndPost($user, $post)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklytaskUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprPost($queryBuilder, $post),
            $this->getExprUser($queryBuilder, $user)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
