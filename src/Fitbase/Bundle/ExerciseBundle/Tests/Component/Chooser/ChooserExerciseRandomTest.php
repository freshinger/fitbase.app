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
        $result = $chooser->choose(array($category1));

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
        $result = $chooser->choose(array($category1));

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
        $result = $chooser->choose(array($category1));

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
        $result = $chooser->choose(array($category2, $category2, $category1));

        $this->assertEquals(count($result), 3);
    }

    /**
     * Check that exercise positions
     * are right
     */
    public function testChooserShouldChooseExercisesWithRightPositions()
    {
        $category1 = new Category();

        $category1->addExercise(
            (new Exercise())
                ->setId(3)
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

        $category2 = new Category();

        $chooser = new ChooserExerciseRandom();
        $result = $chooser->choose(array($category2, $category2, $category1));

        $exercise0 = $result[0];
        $exercise1 = $result[1];
        $exercise2 = $result[2];

        $this->assertEquals($exercise0->getType(), Exercise::MOBILISATION);
        $this->assertEquals($exercise1->getType(), Exercise::KRAEFTIGUNG);
        $this->assertEquals($exercise2->getType(), Exercise::DAEHNUNG);
    }


    public function testChooserShouldChooseExercisesWithRightPositionsWithPreselected()
    {
        $category1 = new Category();

        $category1->addExercise(
            (new Exercise())
                ->setId(3)
                ->setType(Exercise::KRAEFTIGUNG)
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

        $category2 = new Category();

        $chooser = new ChooserExerciseRandom();
        $result = $chooser->choose(array($category2, $category2, $category1),
            (new Exercise())
                ->setId(6)
                ->setType(Exercise::DAEHNUNG)
        );

        $exercise0 = $result[0];
        $exercise1 = $result[1];
        $exercise2 = $result[2];

        $this->assertEquals($exercise0->getType(), Exercise::MOBILISATION);
        $this->assertEquals($exercise1->getType(), Exercise::KRAEFTIGUNG);
        $this->assertEquals($exercise2->getType(), Exercise::DAEHNUNG);
    }
}