<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\ExerciseBundle\Entity;

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