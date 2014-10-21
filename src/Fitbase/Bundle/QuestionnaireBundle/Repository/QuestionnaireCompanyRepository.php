<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:37 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion;

class QuestionnaireCompanyRepository extends EntityRepository
{
    /**
     * Get expression to find records by company
     * @param $queryBuilder
     * @param $company
     * @return mixed
     */
    protected function getExprCompany($queryBuilder, $company)
    {
        if (!empty($company)) {
            $queryBuilder->setParameter('companyId', $company->getId());
            return $queryBuilder->expr()->eq('QuestionnaireCompany.company', ':companyId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     *
     * @param $company
     * @return array
     */
    public function findAllByCompanyAndDate($company)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireCompany');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company)
        ));

        return $queryBuilder->getQuery()->getResult();
    }
}