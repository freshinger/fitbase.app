<?php

/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/02/15
 * Time: 15:48
 */


namespace Fitbase\Bundle\ExerciseBundle\Tests\Service;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Fitbase\Bundle\ExerciseBundle\Service\ServiceExerciseTask;

class ServiceExerciseTaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check that service return 3 exercises
     * from current category
     */
    public function testServiceExerciseTaskShouldReturnThreeExercises()
    {
        $user = new User();

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

        $service = new ServiceExerciseTask();
        $result = $service->random($user, $category1);

        $this->assertEquals(count($result), 3);
    }

    /**
     * Check that chooser return a
     * exercises from a subcategory
     *
     */
    public function testServiceExerciseTaskShouldReturnThreeExercisesFromSubcategory()
    {
        $user = new User();

        $category1 = (new Category())
            ->addExercise(
                (new Exercise())
                    ->setId(1)
                    ->setType(Exercise::MOBILISATION)
            )->addExercise(
                (new Exercise())
                    ->setId(2)
                    ->setType(Exercise::KRAEFTIGUNG)
            )->addExercise(
                (new Exercise())
                    ->setId(3)
                    ->setType(Exercise::DAEHNUNG)
            );

        $category2 = new Category();
        $category2->addChild($category1);
        $category2->addChild($category1);

        $service = new ServiceExerciseTask();
        $result = $service->random($user, $category2);

        $this->assertEquals(count($result), 3);
    }
} 