<?php

namespace Fitbase\Bundle\ExerciseBundle\Component\Chooser;

use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

interface ChooserInterface
{
    /**
     * Process user focus and get a categories list
     * @return array
     */
    public function choose(array $categories = array(), Exercise $result = null);

} 