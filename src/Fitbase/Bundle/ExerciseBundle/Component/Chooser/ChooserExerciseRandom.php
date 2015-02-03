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
    protected $stepsTypes = array(
        0 => array(Exercise::MOBILISATION, Exercise::KRAEFTIGUNG),
        1 => array(Exercise::KRAEFTIGUNG, Exercise::MOBILISATION),
        2 => array(Exercise::DAEHNUNG, Exercise::KRAEFTIGUNG, Exercise::MOBILISATION),
    );

    /**
     * Process user focus and get a categories list
     * @param array $categories
     * @param array $result
     * @return array
     */
    public function choose($categories = array(), array $result = array())
    {
        foreach ($categories as $category) {
            for ($i = count($result); $i < count($this->stepsTypes); $i++) {
                if (($exercise = $this->getExerciseStep($i, $category, $result))) {
                    array_push($result, $exercise);
                }
            }
        }

        return $result;
    }

    /**
     * @param $step
     * @param $category
     * @param array $result
     * @return mixed|null
     */
    protected function getExerciseStep($step, $category, $result = array())
    {
        if (($exercises = $category->getExercises($this->getExerciseStepType($step)))) {
            $exercises = $exercises->filter(function ($entity) use ($result) {
                foreach ($result as $exercise) {
                    if ($exercise->getId() == $entity->getId()) {
                        return false;
                    }
                }
                return true;
            });

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
        return isset($this->stepsTypes[$step]) ? $this->stepsTypes[$step] : null;
    }
}