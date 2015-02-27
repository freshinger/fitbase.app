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
    protected function getExprIdArray($queryBuilder, $collection)
    {
        if (!empty($collection)) {
            $queryBuilder->setParameter('id_array', $collection);
            return $queryBuilder->expr()->in('QuestionnaireUserAnswer.id', ':id_array');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get records by company
     *
     * @param $queryBuilder
     * @param $company
     * @return mixed
     */
    protected function getExprCompany($queryBuilder, $company)
    {
        if (!empty($company)) {
            $queryBuilder->setParameter('company', $company->getId());
            return $queryBuilder->expr()->eq('Company.id', ':company');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get records by question
     *
     * @param $queryBuilder
     * @param $question
     * @return mixed
     */
    protected function getExprQuestion($queryBuilder, $question)
    {
        if (!empty($question)) {
            $queryBuilder->setParameter('question', $question->getId());
            return $queryBuilder->expr()->eq('QuestionnaireUserAnswer.question', ':question');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }

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

    /**
     *
     * @param $company
     * @param $question
     * @return array
     */
    public function findAllByCompanyAndQuestion($company, $question)
    {
        if (($collection = $this->findAllIdByCompanyAndQuestion($company, $question))) {

            $queryBuilder = $this->createQueryBuilder('QuestionnaireUserAnswer');
            $queryBuilder->join('QuestionnaireUserAnswer.user', 'User');
            $queryBuilder->join('User.company', 'Company');

            $queryBuilder->where($queryBuilder->expr()->andX(
                $this->getExprIdArray($queryBuilder, $collection),
                $this->getExprCompany($queryBuilder, $company),
                $this->getExprQuestion($queryBuilder, $question)
            ));
            return $queryBuilder->getQuery()->getResult();
        }

        return null;
    }

    /**
     * @param $company
     * @param $question
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllIdByCompanyAndQuestion($company, $question)
    {
        $tableUser = $this->getEntityManager()->getClassMetadata(
            "Application\Sonata\UserBundle\Entity\User"
        )->getTableName();

        $tableUserAnswer = $this->getEntityManager()->getClassMetadata(
            "Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer"
        )->getTableName();

        $sql = "SELECT $tableUserAnswer.id FROM (
          SELECT * FROM {$tableUserAnswer} ORDER BY user_id ASC, question_id ASC, id ASC
        ) {$tableUserAnswer}
        JOIN $tableUser ON $tableUserAnswer.user_id=$tableUser.id
        WHERE $tableUser.company_id = :company_id
        AND question_id = :question_id
        GROUP BY user_id, question_id";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute(array(
            'company_id' => $company->getId(),
            'question_id' => $question->getId(),

        ));

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}