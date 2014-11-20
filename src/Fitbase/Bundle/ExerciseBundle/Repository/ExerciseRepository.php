<?php

namespace Fitbase\Bundle\ExerciseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExerciseRepository extends EntityRepository
{
    /**
     * Get expression to find records by company
     * @param $queryBuilder
     * @param $category
     * @return mixed
     */
    protected function getExprCategory($queryBuilder, $category)
    {
        if (!empty($category)) {
            $queryBuilder->setParameter('category', $category->getId());
            return $queryBuilder->expr()->eq('Exercise.category', ':category');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find one exercise by company
     * @param $company
     * @param $unique
     * @return null|object
     */
    public function findOneByCompany($company, $unique)
    {
        if (($exercise = $this->find($unique))) {
            if (($category = $exercise->getCategory())) {

                $options = array(
                    'company' => $company,
                    'category' => $category,
                );

                $repositoryCompanyCategory = $this->getEntityManager()->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
                if ($repositoryCompanyCategory->findOneBy($options)) {
                    return $exercise;
                }
            }
        }
        return null;
    }


    /**
     * Find all categories by company
     * @param Category $category
     * @return array
     */
    public function findAllByCategory($category)
    {
        $queryBuilder = $this->createQueryBuilder('Exercise');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCategory($queryBuilder, $category)
        ));

        return $queryBuilder->getQuery()->getResult();
    }
}
