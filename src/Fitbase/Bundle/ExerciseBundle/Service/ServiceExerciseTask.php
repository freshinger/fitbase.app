<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExercise;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 23/10/14
 * Time: 13:12
 */
class ServiceExerciseTask extends ContainerAware
{
    /**
     * Select exercises random
     * @param $user
     * @param array $categories
     * @param null $exercise
     * @return array
     */
    public function random($user, $categories = array(), $exercise = null)
    {
        // For given category user children
        // or a this category if no children exists
        if ($categories instanceof Category) {
            // Define temporary variable
            // to store categories as array
            $categoriesCache = array();
            // by default use a given category
            // to get a exercises from
            array_push($categoriesCache, $categories);
            // If category have a children
            // use a exercises from a children category
            if (count(($children = $categories->getChildren()))) {
                $categoriesCache = is_object($children) ? $children->toArray() : $children;
            }
            // Improve categories from object
            // to array
            $categories = $categoriesCache;
        }

        $result = array();
        if ($exercise instanceof \Fitbase\Bundle\ExerciseBundle\Entity\Exercise) {
            array_push($result, $exercise);
        }

        $chooserExercise = new ChooserExerciseRandom();
        return $chooserExercise->choose($categories, $result);
    }
}