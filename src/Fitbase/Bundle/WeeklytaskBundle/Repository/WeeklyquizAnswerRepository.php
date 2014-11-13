<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;

class WeeklyquizAnswerRepository extends EntityRepository
{
    /**
     * Get expression to find records by quiz
     * @param $queryBuilder
     * @param $quiz
     */
    protected function getExprQuiz($queryBuilder, $quiz)
    {
        if (!empty($quiz)) {

            $queryBuilder->setParameter('quiz', $quiz->getId());
            return $queryBuilder->expr()->eq('WeeklyquizAnswer.quizId', ':quiz');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find records by question
     * @param $queryBuilder
     * @param WeeklyquizQuestion $question
     * @return mixed
     */
    protected function getExprQuestion($queryBuilder, WeeklyquizQuestion $question = null)
    {
        if (!empty($question)) {

            $queryBuilder->setParameter('question', $question->getId());
            return $queryBuilder->expr()->eq('WeeklyquizAnswer.questionId', ':question');
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
            return $queryBuilder->expr()->in('WeeklyquizAnswer.id', ':arrayId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get List of answers by quiz
     * @param Weeklyquiz $quiz
     * @return array
     */
    public function findAllByQuiz(Weeklyquiz $quiz)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuiz($queryBuilder, $quiz)
        ));

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Get expression to find all records by question
     * @param WeeklyquizQuestion $question
     * @return array
     */
    public function findAllByQuestion(WeeklyquizQuestion $question = null)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestion($queryBuilder, $question)
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find list of records by id array
     * @param $arrayId
     * @return array
     */
    public function findAllByIdArray($arrayId)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprIdArray($queryBuilder, $arrayId)
        ));

        return $queryBuilder->getQuery()->getResult();
    }
//
//
//    /**
//     * Find one record by id or collection by id array
//     * @param mixed $id
//     * @return array|null|object
//     */
//    public function find($id)
//    {
//        if (is_array($id)) {
//            return $this->findAllById($id);
//        }
//
//        return $this->findOneBy(array('id' => $id));
//    }
}
