<?php

namespace Fitbase\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\CompanyBundle\Entity\Company;

class CompanyCategoryRepository extends EntityRepository
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
            $queryBuilder->setParameter('company', $company->getId());
            return $queryBuilder->expr()->eq('CompanyCategory.company', ':company');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find records by category aprent
     * @param $queryBuilder
     * @param $category
     * @return mixed
     */
    protected function getExprCategory($queryBuilder, $category)
    {
        if (!empty($category)) {
            $queryBuilder->setParameter('category', $category->getId());
            return $queryBuilder->expr()->eq('CompanyCategory.category', ':category');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find records by category aprent
     * @param $queryBuilder
     * @param $category
     * @return mixed
     */
    protected function getExprCategoryParent($queryBuilder, $category)
    {
        if (!empty($category)) {
            $queryBuilder->setParameter('parent', $category->getId());
            return $queryBuilder->expr()->eq('Category.parent', ':parent');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find all records by slug
     * @param $queryBuilder
     * @param $slug
     * @return mixed
     */
    protected function getExprCategorySlug($queryBuilder, $slug)
    {
        if (!empty($slug)) {
            $queryBuilder->setParameter('slug', $slug);
            return $queryBuilder->expr()->eq('Category.slug', ':slug');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find records by category aprent
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNoParent($queryBuilder)
    {
        return $queryBuilder->expr()->isNull('Category.parent');
    }

    /**
     * Find records by company and parent category
     * @param Company $company
     * @param $category
     * @return array
     */
    public function findAllByCompanyAndCategoryParent(Company $company, $category)
    {
        $queryBuilder = $this->createQueryBuilder('CompanyCategory');
        $queryBuilder->leftJoin('CompanyCategory.category', 'Category');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company),
            $this->getExprCategoryParent($queryBuilder, $category)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Company $company
     * @param null $category
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByCompanyAndCategory(Company $company, $category = null)
    {
        $queryBuilder = $this->createQueryBuilder('CompanyCategory');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company),
            $this->getExprCategory($queryBuilder, $category)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find object by category slug
     * @param Company $company
     * @param null $string
     * @return array
     */
    public function findOneByCompanyAndCategorySlug(Company $company, $string = null)
    {
        $queryBuilder = $this->createQueryBuilder('CompanyCategory');
        $queryBuilder->leftJoin('CompanyCategory.category', 'Category');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company),
            $this->getExprCategorySlug($queryBuilder, $string)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find all categories by company
     * @param Company $company
     * @return array
     */
    public function findAllByCompany(Company $company)
    {
        $queryBuilder = $this->createQueryBuilder('CompanyCategory');
        $queryBuilder->leftJoin('CompanyCategory.category', 'Category');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company),
            $this->getExprNoParent($queryBuilder)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

}
