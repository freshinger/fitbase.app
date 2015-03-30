<?php

namespace Fitbase\Bundle\ExerciseBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserChoice;

class ExerciseUserChoiceRepository extends EntityRepository
{
    /**
     * Get expression by user id
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user = null)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('user', $user->getId());
            return $queryBuilder->expr()->eq('ExerciseUserChoice.user', ':user');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find records by exercise
     * @param $queryBuilder
     * @param null $exercise
     * @return mixed
     */
    protected function getExprExercise($queryBuilder, $exercise = null)
    {
        if (!empty($exercise)) {
            $queryBuilder->setParameter('exercise', $exercise);
            return $queryBuilder->expr()->eq('ExerciseUserChoice.exercise', ':exercise');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Find records by category list
     * @param $queryBuilder
     * @param null $categories
     * @return mixed
     */
    protected function getExprCategories($queryBuilder, $categories = null)
    {
        if (!empty($categories)) {
            $condition = array();
            foreach ($categories as $category) {
                $condition = array_merge($condition,
                    $this->getExprCategoryQueryConditions($queryBuilder, $category)
                );
            }
            return call_user_func_array(array($queryBuilder->expr(), 'orX'), $condition);
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     *
     * @param $queryBuilder
     * @param $category
     * @return array
     */
    protected function getExprCategoryQueryConditions($queryBuilder, $category)
    {
        $condition = array();
        // If category have a children
        // try to find exercises that exists
        // in one of this categories
        if (($children = $category->getChildren())) {
            if (count($children)) {
                foreach ($children as $id => $child) {
                    $queryBuilder->setParameter("category{$child->getId()}", $child);
                    array_push($condition, ":category{$child->getId()} MEMBER OF Exercise.categories");
                }
                return $condition;
            }
        }
        // By default try to find exercises,
        // that exists in given category
        $queryBuilder->setParameter("category{$category->getId()}", $category);
        return array(":category{$category->getId()} MEMBER OF Exercise.categories");
    }

    /**
     * Find record by category
     * @param $queryBuilder
     * @param null $category
     * @return mixed
     */
    protected function getExprCategory($queryBuilder, $category = null)
    {
        if (!empty($category)) {
            return call_user_func_array(array($queryBuilder->expr(), 'orX'),
                $this->getExprCategoryQueryConditions($queryBuilder, $category)
            );
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $user
     * @param $exercise
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndExercise($user, $exercise)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserChoice');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprExercise($queryBuilder, $exercise)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     *
     * @param $user
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndId($user, $id)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserChoice');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprId($queryBuilder, $id)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find list of exercises by user and category-list
     *
     * @param $user
     * @param $categories
     * @return array
     */
    public function findByUserAndCategories($user, $categories)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserChoice');
        $queryBuilder->join('ExerciseUserChoice.exercise', 'Exercise');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprCategories($queryBuilder, $categories)
        ));

        $queryBuilder->groupBy('Exercise.id');

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Find a top exercises selected by users
     *
     * @param $categories
     * @param int $limit
     * @return array
     */
    public function findPopularByCategories($categories, $limit = 1)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserChoice');
        $queryBuilder->select('ExerciseUserChoice, COUNT(ExerciseUserChoice) as c');
        $queryBuilder->join('ExerciseUserChoice.exercise', 'Exercise');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCategories($queryBuilder, $categories)
        ));

        $queryBuilder->setMaxResults($limit);
        $queryBuilder->groupBy('Exercise.id');
        $queryBuilder->addOrderBy('c', 'DESC');

        $result = array();
        if (($response = $queryBuilder->getQuery()->getResult())) {
            foreach ($response as $id => $element) {
                if (!$element instanceof ExerciseUserChoice) {
                    array_push($result, array_shift($element));
                }
            }
        }
        return $result;
    }

    /**
     * Find list of exercises by user and category
     *
     * @param $user
     * @param $category
     * @return array
     */
    public function findByUserAndCategory($user, $category)
    {
        $queryBuilder = $this->createQueryBuilder('ExerciseUserChoice');
        $queryBuilder->join('ExerciseUserChoice.exercise', 'Exercise');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprCategory($queryBuilder, $category)
        ));

        $queryBuilder->groupBy('Exercise.id');

        return $queryBuilder->getQuery()->getResult();
    }
}
