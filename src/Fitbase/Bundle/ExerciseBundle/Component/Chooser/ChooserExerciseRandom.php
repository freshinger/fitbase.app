<?php

namespace Fitbase\Bundle\ExerciseBundle\Component\Chooser;

use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

class ChooserExerciseRandom implements ChooserInterface
{
    /**
     * Define accepted types for each step
     * with respect to type position in array
     * @var array
     */
    protected $steps = array(
        0 => array(Exercise::MOBILISATION, Exercise::KRAEFTIGUNG, null),
        1 => array(Exercise::KRAEFTIGUNG, Exercise::MOBILISATION, null),
        2 => array(Exercise::DAEHNUNG, Exercise::KRAEFTIGUNG, Exercise::MOBILISATION, null),
    );

    /**
     * Choose a set of exercises
     *
     * @param array $categories
     * @param Exercise $preselected
     * @return array
     */
    public function choose(array $categories = array(), Exercise $preselected = null)
    {
        $result = array();

        $typeToStep = array(
            Exercise::MOBILISATION,
            Exercise::KRAEFTIGUNG,
            Exercise::DAEHNUNG,
        );

        $steps = array_keys($this->steps);
        if (!empty($preselected)) {
            if (($step = array_search($preselected->getType(), $typeToStep)) !== null) {
                if (($key = array_search($step, $steps)) !== null) {
                    $result[$key] = $preselected;
                    unset($steps[$key]);
                }
            }
        }


        foreach ($categories as $category) {
            // Try to fill all steps with an exercises from
            // a current category, or go to next category
            foreach ($steps as $step) {

                // Get exercise types for current step
                if (($types = $this->getExerciseStepType($step))) {
                    // Get exercise for selected types
                    // with respect to already choose exercises
                    // and categories list
                    if (($exercise = $this->getExerciseStep($category, $types, $result))) {
                        $result[$step] = $exercise;
                    }
                }

                // Break up if task stack
                // already full for current category
                if ($this->isTaskFull($result)) {
                    break;
                }
            }

            // Break up if task stack
            // already full for all categories
            if ($this->isTaskFull($result)) {
                break;
            }
        }

        // Sort exercises to get
        // an exercises with mobilisation
        // already an position 1
        usort($result, function ($entity1, $entity2) {
            return $entity1->getType() < $entity2->getType() ? -1 : 1;
        });

        return $result;
    }

    /**
     * @param $category
     * @param array $result
     * @return mixed|null
     */
    protected function getExerciseStep($category, $types, $result = array())
    {
        if (($exercises = $category->getExercises($types))) {

            $exercises = $exercises->filter(function ($entity) use ($result) {
                foreach ($result as $exercise) {
                    if ($exercise->getId() == $entity->getId()) {
                        return false;
                    }
                }
                return true;
            });

            // Choose a new exercise random
            // from not existed exercises
            if (($collection = $exercises->toArray())) {
                if (shuffle($collection)) {
                    return array_shift($collection);
                }
            }
        }
        return null;
    }

    /**
     * Get list of types for each step
     * @param $step
     * @return null
     */
    protected function getExerciseStepType($step)
    {
        return isset($this->steps[$step]) ? $this->steps[$step] : null;
    }

    /**
     * Check is task full
     *
     * @param $result
     * @return bool
     */
    protected function isTaskFull($result)
    {
        return (count($result) == count($this->steps));
    }
}