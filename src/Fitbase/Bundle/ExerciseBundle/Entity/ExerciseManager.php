<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\ExerciseBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;


class ExerciseManager implements ExerciseManagerInterface
{
    protected $class;
    protected $objectManager;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Find a exercise by user and id
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @param null $unique
     * @return mixed
     */
    public function findOneById(\Application\Sonata\UserBundle\Entity\User $user = null, $unique = null)
    {
        return $this->repository->findOneById($unique);
    }

    /**
     * Get a random exercise from a category by type
     *
     * @param $categories
     * @param $types
     * @return mixed|null
     */
    public function findOneByCategoriesAndType($categories, $types, $exercises = array())
    {
        if (count($categories)) {
            $collection = array();
            foreach ($categories as $category) {
                if (($exercises = $category->getExercises($types, $exercises))) {
                    // add all exercises from all available categories
                    // into pool and than randomize a collection
                    $collection = array_merge($collection, $exercises->toArray());
                }
            }
            if (count($collection)) {
                if (shuffle($collection)) {
                    // get a first element from
                    // this randomized collection
                    return array_shift($collection);
                }
            }
        }
        return null;
    }

    /**
     * Find exercise type for different steps
     * and for different UserFocusCategoryType
     *
     * @param $type
     * @param int $step
     * @return array
     */
    public function findTypeByFocusCategoryTypeAndStep($type, $step = 0)
    {
        switch ($step) {
            // Get type priority
            // for step 0
            case 0:
                return $this->findTypeByFocusCategoryTypeAndStep0($type);
            // Get type priority
            // for step 1
            case 1:
                return $this->findTypeByFocusCategoryTypeAndStep1($type);
            // Get type priority
            // for step 2
            case 2:
                return $this->findTypeByFocusCategoryTypeAndStep2($type);
        }
    }

    /**
     * Get exercise-type priority for
     * step 0
     *
     * @param $type
     * @return array
     */
    protected function findTypeByFocusCategoryTypeAndStep0($type)
    {
        switch ($type) {
            case 0:
                return array(Exercise::MOBILISATION, Exercise::KRAEFTIGUNG, null);
            case 1:
                return array(Exercise::MOBILISATION, null);
            case 2:
                return array(Exercise::KRAEFTIGUNG, null);
        }
    }

    /**
     * Get exercise-type priority
     * for step 1
     *
     * @param $type
     * @return array
     */
    protected function findTypeByFocusCategoryTypeAndStep1($type)
    {
        switch ($type) {
            case 0:
                return array(Exercise::KRAEFTIGUNG, Exercise::MOBILISATION, null);
            case 1:
                return array(Exercise::MOBILISATION, null);
            case 2:
                return array(Exercise::KRAEFTIGUNG, null);
        }
    }

    /**
     * Get exercise-type priority
     * for step 2
     *
     * @param $type
     * @return array
     */
    protected function findTypeByFocusCategoryTypeAndStep2($type)
    {
        switch ($type) {
            case 0:
                return array(Exercise::DAEHNUNG, Exercise::KRAEFTIGUNG, Exercise::MOBILISATION, null);
            case 1:
                return array(Exercise::DAEHNUNG, Exercise::KRAEFTIGUNG, null);
            case 2:
                return array(Exercise::DAEHNUNG, Exercise::MOBILISATION, null);
        }
    }


    /**
     * Select three exercises
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @param array $categories
     * @param Exercise $exercise
     * @return array
     */
    public function findThreeRandom(\Application\Sonata\UserBundle\Entity\User $user, $categories = array(), Exercise $exercise = null)
    {
        // For given category user children
        // or a this category if no children exists
        if ($categories instanceof \Application\Sonata\ClassificationBundle\Entity\Category) {
            // If category have a children
            // use a exercises from a children category
            if (!count(($children = $categories->getChildren()))) {
                $children = array($categories);
            }

            $categories = is_object($children) ? $children->toArray() : $children;
        }

        return (new ChooserExerciseRandom())->choose($categories, $exercise);
    }
}