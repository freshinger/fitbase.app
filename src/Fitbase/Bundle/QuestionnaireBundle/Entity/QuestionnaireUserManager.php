<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire;


class QuestionnaireUserManager implements QuestionnaireUserManagerInterface
{
    protected $class;
    protected $objectManager;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }


    public function getLastQuestionnaireUserAnswers($questionnaire, $question)
    {

    }

    /**
     * @param $user
     * @param CompanyQuestionnaire $questionnaire
     * @return mixed
     */
    public function findOneByUserAndQuestionnaire($user, CompanyQuestionnaire $questionnaire)
    {
        return $this->repository->findOneByUserAndQuestionnaire($user, $questionnaire);
    }

    /**
     * Find all user answers by company and question
     *
     * @param \Fitbase\Bundle\CompanyBundle\Entity\Company $company
     * @param QuestionnaireQuestion $question
     * @return mixed
     */
    public function findAllByCompanyAndQuestion(\Fitbase\Bundle\CompanyBundle\Entity\Company $company, QuestionnaireQuestion $question)
    {
        $repositoryQuestionnaireUserAnswer = $this->objectManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer');
        return $repositoryQuestionnaireUserAnswer->findAllByCompanyAndQuestion($company, $question);
    }

    /**
     * Find all last answers auf die questions
     * @param $company
     * @param $question
     * @return mixed
     */
    public function findAllLastByCompanyAndQuestion(\Fitbase\Bundle\CompanyBundle\Entity\Company $company, QuestionnaireQuestion $question)
    {
        $repositoryQuestionnaireUserAnswer = $this->objectManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer');
        return $repositoryQuestionnaireUserAnswer->findAllLastByCompanyAndQuestion($company, $question);
    }

    /**
     * Find a first questionnaire in queue
     * @param $user
     * @return mixed
     */
    public function findOneFirstByUser($user)
    {
        return $this->repository->findOneByUserAndNotDoneAndNotPause($user);
    }

}