<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:37 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;

class QuestionnaireQuestionRepository extends EntityRepository
{
    /**
     * Get expression
     * @param $queryBuilder
     * @param $questionnaire
     * @return mixed
     */
    public function getExprQuestionnaire($queryBuilder, Questionnaire $questionnaire)
    {
        if (!empty($questionnaire)) {
            $queryBuilder->setParameter('questionnaireId', $questionnaire->getId());
            return $queryBuilder->expr()->eq('QuestionnaireQuestion.questionnaire', ':questionnaireId');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Find all records by questionnaire user
     * @param QuestionnaireUser $questionnaireUser
     * @return array
     */
    public function findAllByQuestionnaireUser(QuestionnaireUser $questionnaireUser)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireQuestion');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestionnaire($queryBuilder, $questionnaireUser->getQuestionnaire())
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     *
     * @param $questionnaire
     * @return mixed
     */
    public function findAllByQuestionnaire($questionnaire)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireQuestion');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestionnaire($queryBuilder, $questionnaire)
        ));

        return $queryBuilder->getQuery()->getResult();
    }
}