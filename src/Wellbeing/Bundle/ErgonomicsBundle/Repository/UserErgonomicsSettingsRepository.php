<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 14/07/15
 * Time: 12:01
 */

namespace Wellbeing\Bundle\ErgonomicsBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserErgonomicsSettingsRepository extends EntityRepository
{

    /**
     * Find record by code
     *
     * @param $queryBuilder
     * @param null $code
     * @return mixed
     */
    protected function getExprCode($queryBuilder, $code = null)
    {
        if (!empty($code)) {
            $queryBuilder->setParameter('code', $code);
            return $queryBuilder->expr()->eq('UserErgonomicsSettings.code', ':code');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Find settings record by code
     *
     * @param $code
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByCode($code)
    {
        $queryBuilder = $this->createQueryBuilder("UserErgonomicsSettings");
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCode($queryBuilder, $code)
        ));

        $queryBuilder->setMaxResults(1);
        $queryBuilder->orderBy("UserErgonomicsSettings.id", "ASC");

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

} 