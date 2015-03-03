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

class QuestionnaireUserRepository extends EntityRepository
{
    protected function getExprIdArray($queryBuilder, $collection)
    {
        if (!empty($collection)) {
            $queryBuilder->setParameter('id_array', $collection);
            return $queryBuilder->expr()->in('QuestionnaireUser.id', ':id_array');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get not empty assessment
     *
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprAssessmentNotEmpty($queryBuilder)
    {
        return $queryBuilder->expr()->isNotNull('QuestionnaireUser.assessment');
    }

    /**
     * Find not pause records
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotPause($queryBuilder)
    {
        $queryBuilder->setParameter(':pause', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('QuestionnaireUser.pause', ':pause'),
            $queryBuilder->expr()->isNull('QuestionnaireUser.pause')
        );
    }

    /**
     * Get only done object
     * @param $queryBuilder
     * @return mixed
     */
    public function getExprDone($queryBuilder)
    {
        $queryBuilder->setParameter(':done', 1);
        return $queryBuilder->expr()->eq('QuestionnaireUser.done', ':done');
    }

    /**
     * Get all not done tasks
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotDone($queryBuilder)
    {
        $queryBuilder->setParameter(':done', 0);
        return $queryBuilder->expr()->orX(
            $queryBuilder->expr()->eq('QuestionnaireUser.done', ':done'),
            $queryBuilder->expr()->isNull('QuestionnaireUser.done')
        );
    }

    /**
     * get expression to find records by user
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {
            $queryBuilder->setParameter('userId', $user->getId());
            return $queryBuilder->expr()->eq('QuestionnaireUser.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get expression to find records by company
     * @param $queryBuilder
     * @param $company
     * @return mixed
     */
    public function getExprCompany($queryBuilder, $company)
    {
        if (!empty($company)) {
            $queryBuilder->setParameter('companyId', $company->getId());
            return $queryBuilder->expr()->eq('User.company', ':companyId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }


    /**
     * Get expression to find records by questionnaire id
     * @param $queryBuilder
     * @param $questionnaireCompany
     * @return mixed
     */
    protected function getExprQuestionnaireCompany($queryBuilder, $questionnaireCompany)
    {
        if (!empty($questionnaireCompany)) {
            $queryBuilder->setParameter('slice_id', $questionnaireCompany->getId());
            return $queryBuilder->expr()->eq('QuestionnaireUser.slice', ':slice_id');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * Get empty slice record
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprSliceNull($queryBuilder)
    {
        return $queryBuilder->expr()->isNull('QuestionnaireUser.slice');
    }

    /**
     * Find all by questionnaire
     * @param $queryBuilder
     * @param $questionnaire
     * @return mixed
     */
    protected function getExprQuestionnaire($queryBuilder, $questionnaire)
    {
        if (!empty($questionnaire)) {
            $queryBuilder->setParameter('questionnaire_id', $questionnaire->getId());
            return $queryBuilder->expr()->eq('QuestionnaireUser.questionnaire', ':questionnaire_id');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * TODO: check usage
     * @param $queryBuilder
     * @param $string
     * @return mixed
     */
    public function getExprString($queryBuilder, $string = null)
    {
        if (!empty($string)) {
            $queryBuilder->setParameter('string', '%' . $string . '%');

            return $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('User.displayName', ':string'),
                $queryBuilder->expr()->like('User.email', ':string'),
                $queryBuilder->expr()->like('Questionnaire.name', ':string'),
                $queryBuilder->expr()->like('Questionnaire.description', ':string'),
                $queryBuilder->expr()->like('Company.name', ':string')
            );
        }

        return $queryBuilder->expr()->eq('1', '1');
    }


    /**
     * TODO: check usage
     * @param $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndNotDoneAndNotPause($user)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprNotDone($queryBuilder),
            $this->getExprNotPause($queryBuilder)
        ));

        $queryBuilder->addOrderBy('QuestionnaireUser.id', 'ASC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one record by user
     * TODO: check usage
     * @param $user
     * @return mixed
     */
    public function findOneByUserAndNotDone($user)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprNotDone($queryBuilder)
        ));

        $queryBuilder->addOrderBy('QuestionnaireUser.id', 'ASC');

        $queryBuilder->setMaxResults(1);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one record by questionnaire
     * @param $user
     * @param $questionnaire
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndQuestionnaire($user, $questionnaire)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprQuestionnaire($queryBuilder, $questionnaire),
            $this->getExprSliceNull($queryBuilder)
        ));

        $queryBuilder->orderBy('QuestionnaireUser.id', 'DESC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Find one by user and questionnaire user
     * @param $user
     * @param $questionnaireCompany
     * @return array
     */
    public function findOneByUserAndQuestionnaireCompany($user, $questionnaireCompany)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprUser($queryBuilder, $user),
            $this->getExprQuestionnaireCompany($queryBuilder, $questionnaireCompany)
        ));

        $queryBuilder->orderBy('QuestionnaireUser.id', 'DESC');

        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * Find count of weeklytasks by company
     * @param $company
     * @return mixed
     */
    public function findCountByCompany($company)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');

        $queryBuilder->join('QuestionnaireUser.questionnaireCompany', 'QuestionnaireCompany');

        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprCompany($queryBuilder, $company)
        ));

        $queryBuilder->groupBy('QuestionnaireUser.questionnaire');

        if (($result = $queryBuilder->getQuery()->getResult())) {
            return count($result);
        }

        return 0;
    }

    /**
     * Get query builder
     * @param $questionnaireSearch
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder($questionnaireSearch)
    {
        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');

        $queryBuilder->join('QuestionnaireUser.user', 'User');
        $queryBuilder->join('QuestionnaireUser.questionnaire', 'Questionnaire');
        $queryBuilder->join('QuestionnaireUser.questionnaireCompany', 'QuestionnaireCompany');
        $queryBuilder->join('QuestionnaireCompany.company', 'Company');


        $queryBuilder->where($queryBuilder->expr()->andX(
            $this->getExprString($queryBuilder, $questionnaireSearch->getString())
        ));


        $associationOrder = array(
            'id' => 'QuestionnaireUser.id',
            'name' => 'QuestionnaireUser.name',
        );

        $associationBy = array(
            'asc' => 'ASC',
            'desc' => 'DESC'
        );

        if (($order = $questionnaireSearch->getOrder()) and ($by = $questionnaireSearch->getBy())) {
            if (isset($associationOrder[$order]) and isset($associationBy[$by])) {
                $queryBuilder->orderBy($associationOrder[$order], $associationBy[$by]);
            }
        }

        $queryBuilder->addOrderBy('QuestionnaireUser.date', 'DESC');
        $queryBuilder->addOrderBy('QuestionnaireUser.user', 'ASC');

        return $queryBuilder;
    }


//    /**
//     * Find first assessment
//     *
//     * @param $user
//     * @return mixed
//     * @throws \Doctrine\ORM\NonUniqueResultException
//     */
//    public function findFirstAssessmentByUser($user)
//    {
//        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');
//
//        $queryBuilder->where($queryBuilder->expr()->andX(
//            $this->getExprUser($queryBuilder, $user),
//            $this->getExprAssessmentNotEmpty($queryBuilder),
//            $this->getExprNotDone($queryBuilder),
//            $this->getExprNotPause($queryBuilder)
//        ));
//
//        $queryBuilder->addOrderBy('QuestionnaireUser.id', 'ASC');
//        $queryBuilder->setMaxResults(1);
//
//        return $queryBuilder->getQuery()->getOneOrNullResult();
//    }

//
//    public function findAllByQuestionnaireAndNoSlice($questionnaire)
//    {
//        $queryBuilder = $this->createQueryBuilder('QuestionnaireUser');
//
//        $queryBuilder->where($queryBuilder->expr()->andX(
//            $this->getExprQuestionnaire($queryBuilder, $questionnaire),
//            $this->getExprDone($queryBuilder),
//            $this->getExprNotPause($queryBuilder)
//        ));
//
//        return $queryBuilder->getQuery()->getResult();
//    }

}