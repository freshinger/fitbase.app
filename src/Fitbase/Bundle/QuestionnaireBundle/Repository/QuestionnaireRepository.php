<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:37 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class QuestionnaireRepository extends EntityRepository
{

    /**
     *
     * @param $queryBuilder
     * @param $string
     * @return mixed
     */
    public function getExprString($queryBuilder, $string = null)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter('string', '%' . $string . '%');
            return $queryBuilder->expr()->like('Questionnaire.name', ':string');
        }

        return $queryBuilder->expr()->eq('1', '1');
    }


    /**
     * Get query builder
     * @param $questionnaireSearch
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder($questionnaireSearch)
    {
        $queryBuilder = $this->createQueryBuilder('Questionnaire');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprString($queryBuilder, $questionnaireSearch->getString())
        ));

        $associationOrder = array(
            'id' => 'Questionnaire.id',
            'name' => 'Questionnaire.name',
        );

        $associationBy = array(
            'asc' => 'ASC',
            'desc' => 'DESC'
        );

        if (($order = $questionnaireSearch->getOrder()) and ($by = $questionnaireSearch->getBy())) {
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
        $queryBuilder = $this->createQueryBuilder('Questionnaire');
        $queryBuilder->select('COUNT(Questionnaire)');

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
} 