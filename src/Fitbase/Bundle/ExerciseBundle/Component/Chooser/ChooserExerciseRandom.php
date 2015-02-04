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
        0 => array(Exercise::MOBILISATION, null),
        1 => array(Exercise::KRAEFTIGUNG, null),
        2 => array(Exercise::DAEHNUNG, null),
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

        for ($step = 0; $step < count($this->steps); $step++) {

            foreach ($categories as $category) {
                if (($types = $this->getExerciseStepType($step))) {

                    if (!empty($preselected)) {
                        if (in_array($preselected->getType(), $types)) {
                            if (!in_array($preselected, $result)) {
                                array_push($result, $preselected);
                                continue;
                            }
                        }
                    }

                    if (($exercise = $this->getExerciseStep($step, $types, $category, $result))) {
                        array_push($result, $exercise);
                        continue;
                    }
                }

                if (count($result) == count($this->steps)) {
                    break;
                }
            }
        }

        usort($result, function ($entity1, $entity2) {
            return $entity1->getType() < $entity2->getType() ? -1 : 1;
        });

        return $result;
    }

    /**
     * @param $step
     * @param $category
     * @param array $result
     * @return mixed|null
     */
    protected function getExerciseStep($step, $types, $category, $result = array())
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
}