<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;

class WeeklyquizUserAnswerRepository extends EntityRepository
{

    /**
     * Get expr to find element by user
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    public function getExprUser($queryBuilder, $user)
    {
        return $this->getExprUserId($queryBuilder, $user->getId());
    }

    /**
     * Get expression to find record by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    public function getExprUserId($queryBuilder, $userId)
    {
        if (!empty($userId)) {

            $queryBuilder->setParameter('userId', $userId);
            return $queryBuilder->expr()->eq('WeeklyquizUserAnswer.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find record by quiz id
     * @param $queryBuilder
     * @param $quizId
     * @return mixed
     */
    public function getExprQuizId($queryBuilder, $quizId)
    {
        if (!empty($quizId)) {

            $queryBuilder->setParameter('quizId', $quizId);
            return $queryBuilder->expr()->eq('WeeklyquizUserAnswer.quiz', ':quizId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Get expr to find element by answer
     * @param $queryBuilder
     * @param WeeklyquizAnswer $answer
     * @return mixed
     */
    protected function getExprAnswer($queryBuilder, WeeklyquizAnswer $answer)
    {
        if (!empty($answer)) {

            $queryBuilder->setParameter('answerId', $answer->getId());
            return $queryBuilder->expr()->eq('WeeklyquizUserAnswer.answerId', ':answerId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find record by question
     * @param $queryBuilder
     * @param $question
     * @return mixed
     */
    protected function getExprQuestion($queryBuilder, $question)
    {
        return $this->getExprQuestionId($queryBuilder, $question->getId());
    }

    /**
     * Get expression to find records by question id
     * @param $queryBuilder
     * @param $questionId
     * @return mixed
     */
    protected function getExprQuestionId($queryBuilder, $questionId)
    {
        if (!empty($questionId)) {

            $queryBuilder->setParameter('questionId', $questionId);
            return $queryBuilder->expr()->eq('WeeklyquizUserAnswer.question', ':questionId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get records by weekly task user quiz
     * @param WeeklyquizUser $weeklytaskUserQuiz
     * @return array
     */
    public function findAllByWeeklyquizUser(WeeklyquizUser $weeklytaskUserQuiz)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUserAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserId($queryBuilder, $weeklytaskUserQuiz->getUserId()),
            $this->getExprQuizId($queryBuilder, $weeklytaskUserQuiz->getQuizId())
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find one record by user and answer
     * @param $user
     * @param $questionId
     * @return mixed
     * @internal param \Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion $question
     */
    public function findOneByUserAndQuestionId($user, $questionId)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUserAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprQuestionId($queryBuilder, $questionId)
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find answer by user and quiz and question
     * @param $user
     * @param $quiz
     * @param $question
     * @return mixed
     */
    public function findOneByUserAndQuizAndQuestion($user, $quiz, $question)
    {
        $queryBuilder = $this->createQueryBuilder('WeeklyquizUserAnswer');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUserId($queryBuilder, $user->getId()),
            $this->getExprQuizId($queryBuilder, $quiz->getId()),
            $this->getExprQuestionId($queryBuilder, $question->getId())
        ));

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
