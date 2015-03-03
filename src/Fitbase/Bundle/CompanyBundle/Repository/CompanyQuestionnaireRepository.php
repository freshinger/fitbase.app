<?php

namespace Fitbase\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CompanyQuestionnaireRepository extends EntityRepository
{

    /**
     * Find record by id
     *
     * @param $queryBuilder
     * @param $unique
     * @return mixed
     */
    protected function getExprUnique($queryBuilder, $unique)
    {
        if (!empty($unique)) {
            $queryBuilder->setParameter('unique', $unique);
            return $queryBuilder->expr()->eq('CompanyQuestionnaire.id', ':unique');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find records by company
     * @param $queryBuilder
     * @param $company
     * @return mixed
     */
    protected function getExprCompany($queryBuilder, $company)
    {
        if (!empty($company)) {
            $queryBuilder->setParameter('company_id', $company->getId());
            return $queryBuilder->expr()->eq('CompanyQuestionnaire.company', ':company_id');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     *  Find records by unique identifier and company
     *
     * @param $unique
     * @param $company
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUniqueAndCompany($unique, $company)
    {
        $queryBuilder = $this->createQueryBuilder('CompanyQuestionnaire');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company),
            $this->getExprUnique($queryBuilder, $unique)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

}
