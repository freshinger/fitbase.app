<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExercise;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseFilter;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;
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
     * Select 3 exercises
     * @param $user
     * @return array
     */
    public function choose($user, $category = null, \Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise = null)
    {
        // Get category list from focus
        // with respect to priority
        if (($chooserCategory = $this->container->get('chooser_category'))) {
            if (($categories = $chooserCategory->choose($user->getFocus()))) {

                // Replace all selected categories
                // with only one category
                // needs to choose a exercise from
                // this one
                if (!empty($category)) {
                    $categories = array($category);
                }

                $preselected = array();
                if (!empty($exercise)) {
                    array_push($preselected, $exercise);
                    if (!($categories = $exercise->getCategories())) {
                        // TODO: notify administration
                    }
                }

                $entityManager = $this->container->get('entity_manager');
                $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');

                // Extra filter to check is
                // a exercise already done
                $chooserNotProcessed = new ChooserExerciseFilter(function ($exercise0) use ($user, $exercise, $repositoryExerciseUser) {
                    return !$repositoryExerciseUser->findOneByUserAndExercise($user, $exercise0);
                });

                if (!count(($exercises = $chooserNotProcessed->choose($categories, $preselected)))) {
                    $chooserRandomized = new ChooserExerciseRandom();
                    return $chooserRandomized->choose($categories, $preselected);
                }


                return $exercises;
            }
        }

        return array();
    }


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