<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:37 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;

class QuestionnaireUserAnswerRepository extends EntityRepository
{

    /**
     * Get expression
     * @param $queryBuilder
     * @param $questionnaireUser
     * @return mixed
     */
    public function getExprQuestionnaireUser($queryBuilder, QuestionnaireUser $questionnaireUser)
    {
        if (!empty($questionnaireUser)) {
            $queryBuilder->setParameter('questionnaireUser', $questionnaireUser->getId());
            return $queryBuilder->expr()->eq('QuestionnaireUserAnswer.questionnaireUser', ':questionnaireUser');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get query count
     * @param QuestionnaireUser $questionnaireUser
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCountByQuestionnaireUser(QuestionnaireUser $questionnaireUser)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUserAnswer');
        $queryBuilder->select('COUNT(QuestionnaireUserAnswer)');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestionnaireUser($queryBuilder, $questionnaireUser)
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Find all answers by questionnaire
     * @param QuestionnaireUser $questionnaireUser
     * @return array
     */
    public function findAllByQuestionnaireUser(QuestionnaireUser $questionnaireUser)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUserAnswer');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestionnaireUser($queryBuilder, $questionnaireUser)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all questions
     *  TODO: rewrite to query
     * @param QuestionnaireUser $questionnaireUser
     * @return array
     */
    public function findAllQuestionsByQuestionnaireUser(QuestionnaireUser $questionnaireUser)
    {
        if (($collection = $this->findAllByQuestionnaireUser($questionnaireUser))) {
            $collection = new ArrayCollection($collection);
            return $collection->map(function ($entity) {
                return $entity->getQuestion();
            })->toArray();
        }
        return array();
    }
}