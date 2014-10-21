<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:32 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    /**
     * Check is section exists
     * @param $unique
     * @return mixed
     */
    public function isSectionExists($unique)
    {
        $queryBuilder = $this->createQueryBuilder('Question');
        $queryBuilder->select('COUNT(Question.id)');
        $queryBuilder->where($queryBuilder->expr()->eq('Question.section', ':section'));
        $queryBuilder->setParameter("section", $unique);
        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}