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
            // If category have a children
            // use a exercises from a children category
            $categories = $this->getCategoriesFromCategory($categories);
        }

        $preselected = array();
        if ($exercise instanceof \Fitbase\Bundle\ExerciseBundle\Entity\Exercise) {
            array_push($preselected, $exercise);
        }

        $chooserExercise = new ChooserExerciseRandom();
        return $chooserExercise->choose($categories, $preselected);
    }

    /**
     * Get categories array from category
     *
     * @param $category
     * @return array
     */
    protected function getCategoriesFromCategory($category)
    {
        // If category have a children
        // use a exercises from a children category
        if (count(($children = $category->getChildren()))) {
            return is_object($children) ? $children->toArray() : $children;
        }
        // Improve categories
        // from object to array
        return array($category);
    }
}