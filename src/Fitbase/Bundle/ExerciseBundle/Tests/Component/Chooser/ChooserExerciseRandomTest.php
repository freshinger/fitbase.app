<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/02/15
 * Time: 14:54
 */

namespace Fitbase\Bundle\ExerciseBundle\Tests\Component\Chooser;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

class ChooserExerciseRandomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that chooser return 3 exercises
     * with different types
     *
     */
    public function testChooserShouldReturnThreeExercises()
    {
        $category1 = new Category();
        $category1->addExercise(
            (new Exercise())
                ->setId(1)
                ->setType(Exercise::MOBILISATION)
        );
        $category1->addExercise(
            (new Exercise())
                ->setId(2)
                ->setType(Exercise::KRAEFTIGUNG)
        );
        $category1->addExercise(
            (new Exercise())
                ->setId(3)
                ->setType(Exercise::DAEHNUNG)

        );

        $chooser = new ChooserExerciseRandom();
        $result = $chooser->choose(array($category1), array());

        $this->assertEquals(count($result), 3);
    }

    /**
     * Test chooser should not return
     * a simple exercise twice
     *
     */
    public function testChooserShouldNotReturnExerciseTwice()
    {
        $category1 = new Category();
        $category1->addExercise(
            (new Exercise())
                ->setId(1)
                ->setType(Exercise::MOBILISATION)
        );
        $category1->addExercise(
            (new Exercise())
                ->setId(1)
                ->setType(Exercise::KRAEFTIGUNG)
        );
        $category1->addExercise(
            (new Exercise())
                ->setId(3)
                ->setType(Exercise::DAEHNUNG)

        );

        $chooser = new ChooserExerciseRandom();
        $result = $chooser->choose(array($category1), array());

        $this->assertNotEquals(count($result), 3);
    }

    /**
     * Chooser should not return haehnung
     * as a first exercise
     */
    public function testChooserShouldNotReturnDaehnungFirstOrSecond()
    {
        $category1 = new Category();
        $category1->addExercise(
            (new Exercise())
                ->setId(1)
                ->setType(Exercise::DAEHNUNG)
        );

        $category1->addExercise(
            (new Exercise())
                ->setId(4)
                ->setType(Exercise::MOBILISATION)
        );

        $category1->addExercise(
            (new Exercise())
                ->setId(2)
                ->setType(Exercise::KRAEFTIGUNG)
        );
        $category1->addExercise(
            (new Exercise())
                ->setId(3)
                ->setType(Exercise::DAEHNUNG)

        );

        $chooser = new ChooserExerciseRandom();
        $result = $chooser->choose(array($category1), array());

        $this->assertFalse(in_array($result[0]->getId(), array(1, 3)));
        $this->assertFalse(in_array($result[1]->getId(), array(1, 3)));
    }

    /**
     * Check that chooser use a second category
     * when first category is empty
     *
     */
    public function testChooserShouldUseSecondCategoryIfFirstCategoryEmpty()
    {
        $category1 = new Category();

        $category1->addExercise(
            (new Exercise())
                ->setId(4)
                ->setType(Exercise::MOBILISATION)
        );

        $category1->addExercise(
            (new Exercise())
                ->setId(2)
                ->setType(Exercise::KRAEFTIGUNG)
        );
        $category1->addExercise(
            (new Exercise())
                ->setId(3)
                ->setType(Exercise::DAEHNUNG)

        );

        $category2 = new Category();

        $chooser = new ChooserExerciseRandom();
        $result = $chooser->choose(array($category2, $category2, $category1), array());

        $this->assertEquals(count($result), 3);
    }

}