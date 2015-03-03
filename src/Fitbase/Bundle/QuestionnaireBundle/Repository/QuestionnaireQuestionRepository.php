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
use Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;

class QuestionnaireQuestionRepository extends EntityRepository
{

    /**
     * @param $queryBuilder
     * @param $categories
     * @return mixed
     */
    public function getExprCategories($queryBuilder, $categories)
    {
        $categories = (new ArrayCollection($categories))->map(function ($entity) {
            return $entity->getId();
        });

        $queryBuilder->setParameter('categories', $categories->toArray());
        return $queryBuilder->expr()->orx(
            $queryBuilder->expr()->in('Category.id', ':categories'),
            $queryBuilder->expr()->isNull('Category.id')
        );
    }

    /**
     * @param $queryBuilder
     * @param $questions
     * @return mixed
     */
    public function getExprNotQuestions($queryBuilder, $questions)
    {
        if (count($questions)) {

            $questions = (new ArrayCollection($questions))->map(function ($entity) {
                return $entity->getId();
            });

            $queryBuilder->setParameter('notQuestions', $questions->toArray());
            return $queryBuilder->expr()->notIn('QuestionnaireQuestion.id', ':notQuestions');
        }

        return $queryBuilder->expr()->eq('1', '1');
    }


    /**
     * Get expression
     * @param $queryBuilder
     * @param $questionnaire
     * @return mixed
     */
    protected function getExprQuestionnaire($queryBuilder, Questionnaire $questionnaire)
    {
        if (!empty($questionnaire)) {
            $queryBuilder->setParameter('questionnaireId', $questionnaire->getId());
            return $queryBuilder->expr()->eq('QuestionnaireQuestion.questionnaire', ':questionnaireId');
        }
        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Get questions with answers for this questionnaire user object
     * @param $questionnaireUser
     * @return mixed
     */
    protected function getExcludedQuestions($questionnaireUser)
    {
        $entityManager = $this->getEntityManager();
        $repositoryQuestionnaireAnswer = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer');
        return $repositoryQuestionnaireAnswer->findAllQuestionsByQuestionnaireUser($questionnaireUser);
    }

    /**
     * Get excluded categoryes,
     * @param $questionnaireUser
     * @return array
     */
    protected function getIncludedCategories($questionnaireUser)
    {
        $excludeCategories = array();

        if (($user = $questionnaireUser->getUser())) {
            if (($focus = $user->getFocus())) {
                if (($focusCategories = $focus->getCategories())) {
                    $excludeCategories = $focusCategories->map(function ($entity) {
                        return $entity->getCategory();
                    })->toArray();
                }
            }
        }

        return $excludeCategories;
    }


    /**
     * Get query count
     * @param QuestionnaireUser $questionnaireUser
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCountByQuestionnaireUser(QuestionnaireUser $questionnaireUser = null)
    {
        $questionnaire = null;
        if (($companyQuestionnaire = $questionnaireUser->getQuestionnaire())) {
            $questionnaire = $companyQuestionnaire->getQuestionnaire();
        }

        $queryBuilder = $this->createQueryBuilder('QuestionnaireQuestion');
        $queryBuilder->leftJoin('QuestionnaireQuestion.categories', 'Category');
        $queryBuilder->select('COUNT(QuestionnaireQuestion)');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestionnaire($queryBuilder, $questionnaire),
            $this->getExprCategories($queryBuilder, $this->getIncludedCategories($questionnaireUser)),
            $this->getExprNotQuestions($queryBuilder, $this->getExcludedQuestions($questionnaireUser))
        ));

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }


    /**
     * Find all records by questionnaire user
     * @param QuestionnaireUser $questionnaireUser
     * @return array
     */
    public function findAllByQuestionnaireUser(QuestionnaireUser $questionnaireUser, $limit = null)
    {
        $questionnaire = null;
        if (($companyQuestionnaire = $questionnaireUser->getQuestionnaire())) {
            $questionnaire = $companyQuestionnaire->getQuestionnaire();
        }


        $queryBuilder = $this->createQueryBuilder('QuestionnaireQuestion');
        $queryBuilder->leftJoin('QuestionnaireQuestion.categories', 'Category');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprQuestionnaire($queryBuilder, $questionnaire),
            $this->getExprCategories($queryBuilder, $this->getIncludedCategories($questionnaireUser)),
            $this->getExprNotQuestions($queryBuilder, $this->getExcludedQuestions($questionnaireUser))
        ));

        $queryBuilder->addOrderBy('Category.position', 'ASC');

        if (!is_null($limit)) {
            if (($questionCount = $this->findCountByQuestionnaireUser($questionnaireUser)) > $limit) {
                $queryBuilder->setMaxResults(floor(($questionCount / ($questionCount / $limit))));
            }
        }

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