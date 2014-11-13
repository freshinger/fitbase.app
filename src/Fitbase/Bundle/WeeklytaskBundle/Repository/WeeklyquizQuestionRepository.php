<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;

class WeeklyquizQuestionRepository extends EntityRepository
{
    /**
     * Get expr to find records by quiz
     * @param $queryBuilder
     * @param $quiz
     * @return mixed
     */
    public function getExprQuiz($queryBuilder, Weeklyquiz $quiz = null)
    {
        if (!empty($quiz)) {

            $queryBuilder->setParameter('quiz', $quiz->getId());
            return $queryBuilder->expr()->eq('WeeklyquizQuestion.quizId', ':quiz');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find record by user quiz
     * @param $queryBuilder
     * @param WeeklyquizUser $userQuiz
     * @return mixed
     */
    public function getExprUserQuiz($queryBuilder, WeeklyquizUser $userQuiz = null)
    {
        if (!empty($userQuiz)) {

            $queryBuilder->setParameter('quiz', $userQuiz->getQuiz()->getId());
            return $queryBuilder->expr()->eq('WeeklyquizQuestion.quiz', ':quiz');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find all questions by quiz
     * @param Weeklyquiz $quiz
     * @return array
     */
    public function findAllByQuiz(Weeklyquiz $quiz = null)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizQuestion');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuiz($queryBuilder, $quiz)
        ));

        $queryBuilder->orderBy('WeeklyquizQuestion.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all by user quiz
     * @param $weeklytaskUserQuiz
     * @return array
     */
    public function findAllByWeeklyquizUser($weeklytaskUserQuiz)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizQuestion');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserQuiz($queryBuilder, $weeklytaskUserQuiz)
        ));

        $queryBuilder->orderBy('WeeklyquizQuestion.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

}
