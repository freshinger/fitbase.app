<?php

namespace Fitbase\Bundle\ExerciseBundle\Component\Chooser;

use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

class ChooserExerciseRandom implements ChooserInterface
{
    /**
     * Process user focus and get a categories list
     * @param array $categories
     * @param array $result
     * @return array
     */
    public function choose($categories = array(), array $result = array())
    {
        $types = array(
            array(Exercise::MOBILISATION, Exercise::KRAEFTIGUNG),
            array(Exercise::KRAEFTIGUNG, Exercise::MOBILISATION),
            array(Exercise::KRAEFTIGUNG, Exercise::DAEHNUNG, Exercise::MOBILISATION),
        );


        foreach ($categories as $category) {
            for ($i = count($result); $i < count($types); $i++) {
                if (($type = $types[$i])) {
                    if (($exercises = $category->getExercises($type))) {

                        do {

                            $exercise = $this->exercise($exercises);

                        } while (in_array($exercise, $result));

                        array_push($result, $exercise);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get a exercise
     * @param $exercises
     * @return mixed
     */
    protected function exercise($exercises)
    {
        if (($collection = $exercises->toArray())) {
            if (shuffle($collection)) {
                return array_shift($collection);
            }
        }
        return null;
    }
}