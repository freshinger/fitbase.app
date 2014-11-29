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

class QuestionnaireAnswerRepository extends EntityRepository
{
    /**
     * Get expression to find records by question
     * @param $queryBuilder
     * @param $question
     * @return mixed
     */
    public function getExprQuestion($queryBuilder, $question)
    {
        if (!empty($question)) {
            $queryBuilder->setParameter('questionId', $question->getId());
            return $queryBuilder->expr()->eq('QuestionnaireAnswer.question', ':questionId');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find question by id array
     * @param $queryBuilder
     * @param $arrayId
     * @return mixed
     */
    protected function getExprIdArray($queryBuilder, $arrayId)
    {
        if (!empty($arrayId)) {

            $queryBuilder->setParameter('arrayId', $arrayId);
            return $queryBuilder->expr()->in('QuestionnaireAnswer.id', ':arrayId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find all records by question
     * @param QuestionnaireQuestion $question
     * @return array
     */
    public function findAllByQuestion(QuestionnaireQuestion $question)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestion($queryBuilder, $question)
        ));

        $queryBuilder->orderBy('QuestionnaireAnswer.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Find all records by question
     * @param QuestionnaireQuestion $question
     * @return array
     */
    public function findAllByQuestionAndOrderByName(QuestionnaireQuestion $question)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestion($queryBuilder, $question)
        ));

        $queryBuilder->orderBy('QuestionnaireAnswer.name', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find list of records by id array
     * @param $arrayId
     * @return array
     */
    public function findAllById($arrayId)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprIdArray($queryBuilder, $arrayId)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find one or more records by id
     * @param mixed $mixed
     * @return array|null|object
     */
//    public function find($mixed)
//    {
//        if (is_array($mixed)) {
//            return $this->findAllById($mixed);
//        }
//
//        return $this->findOneBy(array('id' => $mixed));
//    }
}