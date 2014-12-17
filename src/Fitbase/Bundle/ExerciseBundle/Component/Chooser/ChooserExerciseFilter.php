<?php

namespace Fitbase\Bundle\ExerciseBundle\Component\Chooser;

use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

class ChooserExerciseFilter
{
    protected $filter;

    /**
     * Class constructor
     * @param callable $filter
     */
    public function __construct(\Closure $filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * Process user focus and get a categories list
     * @return array
     */
    public function choose($categories = array(), array $result = array())
    {
        $types = array(
            array(Exercise::MOBILISATION, Exercise::KRAEFTIGUNG),
            array(Exercise::KRAEFTIGUNG, Exercise::MOBILISATION),
            array(Exercise::KRAEFTIGUNG, Exercise::DAEHNUNG),
        );

        foreach ($categories as $category) {
            for ($i = count($result); $i < count($types); $i++) {
                if (($type = $types[$i])) {
                    if (($exercises = $category->getExercises($type))) {
                        if (($exercise = $this->exercise($exercises, $this->filter))) {
                            if (!in_array($exercise, $result)) {
                                array_push($result, $exercise);
                            }
                        }
                    }
                }
            }
        }

        if (count($result) == 3) {
            return $result;
        }

        return array();
    }

    /**
     * Get a exercise
     * @param callable $filter
     * @param $exercises
     * @return mixed
     */
    protected function exercise($exercises, \Closure $filter = null)
    {
        foreach ($exercises as $index => $exercise) {
            if (!($filter instanceof \Closure)) {
                return $exercise;
            }

            if (call_user_func($filter, $exercise)) {
                return $exercise;
            }
        }

        return null;
    }
}