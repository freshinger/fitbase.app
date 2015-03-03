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
            return $queryBuilder->expr()->eq('QuestionnaireCompany.id', ':unique');
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
            $queryBuilder->setParameter('companyId', $company->getId());
            return $queryBuilder->expr()->eq('QuestionnaireCompany.company', ':companyId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find not pause records
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotProcessed($queryBuilder)
    {
        $queryBuilder->setParameter(':processed', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('QuestionnaireCompany.processed', ':processed'),
            $queryBuilder->expr()->isNull('QuestionnaireCompany.processed')
        );
    }

    /**
     * @param $queryBuilder
     * @param $datetime
     * @return mixed
     */
    protected function getExprDateTimeLt($queryBuilder, $datetime)
    {
        if (!empty($datetime)) {
            $queryBuilder->setParameter('datetime', $datetime);
            return $queryBuilder->expr()->lt('QuestionnaireCompany.date', ':datetime');
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
        $queryBuilder = $this->createQueryBuilder('QuestionnaireCompany');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company),
            $this->getExprUnique($queryBuilder, $unique)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find all questionnaire company objects by datetime
     *
     * @param \DateTime $datetime
     * @return array
     */
    public function findAllNotProcessedByDate(\DateTime $datetime)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireCompany');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprNotProcessed($queryBuilder),
            $this->getExprDateTimeLt($queryBuilder, $datetime)
        ));

        return $queryBuilder->getQuery()->getResult();
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