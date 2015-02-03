<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Application\Sonata\ClassificationBundle\Entity\Category;
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
class ServiceExerciseTask extends ContainerAware
{
    protected $entityManager;
    protected $serviceExercise;

    public function __construct(ServiceExercise $serviceExercise, $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->serviceExercise = $serviceExercise;
    }

    /**
     * Select exercises random
     * @param $user
     * @param null $category
     * @param null $preselected
     * @return array
     */
    public function random($user, $category = null, $preselected = null)
    {
        $categories = array();
        if ($category instanceof Category) {
            array_push($categories, $category);
            if (count(($children = $category->getChildren()))) {
                $categories = $children->toArray();
            }
        }

        $result = array();
        if ($preselected instanceof \Fitbase\Bundle\ExerciseBundle\Entity\Exercise) {
            array_push($result, $preselected);
        }

        $chooserExercise = new ChooserExerciseRandom();
        return $chooserExercise->choose($categories, $result);
    }


    /**
     * Select 3 exercises
     * @param $user
     * @return array
     */
    public function choose($user, \Fitbase\Bundle\ExerciseBundle\Entity\Exercise $exercise = null)
    {
        $categories = array();
        $preselected = array();

        if (!empty($exercise)) {
            array_push($preselected, $exercise);
            $categories = $exercise->getCategories();
        }

        if (empty($categories)) {
            $repositoryCategory = $this->entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
            if (($category = $repositoryCategory->findOneBySlug('ruecken'))) {
                $categories = array($category);
                if (($children = $category->getChildren())) {
                    $categories = array_merge($categories, $children->toArray());
                }
            }
        }

        if (!empty($categories) and count($categories)) {

//            $entityManager = $this->container->get('entity_manager');
//            $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');

            // Extra filter to check is
            // a exercise already done
//            $chooserExercise = new ChooserExerciseFilter(function ($exercise0) use ($user, $exercise, $repositoryExerciseUser) {
//                return !$repositoryExerciseUser->findOneByUserAndExercise($user, $exercise0);
//            });
//
//            if (count(($exercises = $chooserExercise->choose($categories, $preselected))) >= 3) {
//                return $exercises;
//            }

            $chooserExercise = new ChooserExerciseRandom();
            return $chooserExercise->choose($categories, $preselected);
        }

        return array();
    }
}