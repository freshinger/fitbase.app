<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\FileProvider;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 23/10/14
 * Time: 13:12
 */
class ServiceExercise extends ContainerAware
{
    /**
     * @param $datetime
     * @return mixed
     */
    public function send($datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');
        return $repositoryWeeklytaskUser->findAllNotProcessedByDateTime($datetime);
    }

    /**
     *
     * @param $user
     * @return array
     */
    public function categories($user, $unique = null)
    {
        if (($company = $user->getCompany())) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');

            if (($companyCategory = $repositoryCompanyCategory->findOneByCompanyAndCategorySlug($company, $unique))) {
                return $repositoryCompanyCategory->findAllByCompanyAndCategoryParent($company, $companyCategory->getCategory());
            }
            return $repositoryCompanyCategory->findAllByCompany($company);
        }

        return array();
    }

    /**
     *
     * @param $user
     * @return array
     */
    public function exercises($user, $unique = null)
    {
        $entityManager = $this->container->get('entity_manager');

        if (is_array(($categories = $unique))) {
            $result = array();
            $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');
            foreach ($categories as $category) {
                $result = array_merge($result, $repositoryExercise->findAllByCategory($category));
            }
            return $result;
        }


        if (($company = $user->getCompany())) {

            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
            if (($companyCategory = $repositoryCompanyCategory->findOneByCompanyAndCategorySlug($company, $unique))) {

                $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');
                return $repositoryExercise->findAllByCategory($companyCategory->getCategory());
            }
        }

        return array();
    }

    /**
     * Get exercise using user, company and category
     * @param $user
     * @param null $unique
     * @return null
     */
    public function exercise($user, $unique = null)
    {
        if (($company = $user->getCompany())) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

            return $repositoryExercise->findOneByCompany($company, $unique);
        }

        return null;
    }
}