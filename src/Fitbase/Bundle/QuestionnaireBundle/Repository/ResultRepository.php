<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:48 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ResultRepository extends EntityRepository
{

    public function getHealthPercentage($user, $section)
    {
        $repositoryAnswer = $this->getEntityManager()
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Answer');
        $repositoryQuestion = $this->getEntityManager()
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Question');

        $questions = $repositoryQuestion->findBy(array('section' => $section));

        $questionsToRequest = array();
        foreach ($questions as $question) {
            array_push($questionsToRequest, $question->getId());
        }

        $queryBuilder = $this->createQueryBuilder('Result');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('Result.userId', ':userId'),
            $queryBuilder->expr()->in('Result.questionId', ':questionId')
        ))
            ->setParameter('userId', $user->getId())
            ->setParameter('questionId', $questionsToRequest);

        $results = $queryBuilder->getQuery()->getResult();

        $percentage = ($section == 1) ? 75 : 50;
        foreach ($results as $result) {
            $percentage += (int)$repositoryAnswer->getAnswerPercentage(
                explode(',', $result->getAnswer()),
                $result->getQuestionId()
            );
        }

        $percentage = ($percentage > 100) ? 100 : $percentage;
        $percentage = ($percentage < 0) ? 0 : $percentage;

        return $percentage;
    }
}