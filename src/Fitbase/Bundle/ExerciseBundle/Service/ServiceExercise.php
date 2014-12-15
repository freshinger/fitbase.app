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
     * Get categories from user focus and user company
     * @param $user
     * @return array
     */
    public function getFocusCategories($user, $subcategory = null)
    {
        $category = $user->getFocus();
        if ($subcategory !== null) {
            $category = $subcategory;
        }

        // if user has no company
        // show subcategories from focus
        if (($company = $user->getCompany())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
            // Check is focus assigned to user company
            // TODO: user have to contact administrator here
            if (($companyCategory = $repositoryCompanyCategory->findOneByCompanyAndCategory($company, $category))) {
                return $category->getChildren();
            }
        }

        return array();
    }

    /**
     * @param $user
     * @return array
     */
    public function getFocusExercises($user, $subcategory = null)
    {
        $category = $user->getFocus();
        if ($subcategory !== null) {
            $category = $subcategory;
        }

        $entityManager = $this->container->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');
        $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');


        if (($company = $user->getCompany())) {
            // Check is focus assigned to user company
            // TODO: user have to contact administrator here
            if (($companyCategory = $repositoryCompanyCategory->findOneByCompanyAndCategory($company, $category))) {
                $result = $repositoryExercise->findAllByCategory($category);

                if (($categories = $category->getChildren())) {
                    foreach ($categories as $categoryChild) {
                        $result = array_merge($result, $repositoryExercise->findAllByCategory($categoryChild));
                    }
                }

                return $result;
            }
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
}