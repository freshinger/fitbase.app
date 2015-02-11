<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;


class WeeklytaskManager implements WeeklytaskManagerInterface
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
     * Find all weeklytask user objects by user and category
     * @param $user
     * @param $category
     * @return mixed
     */
    public function findAllByUserAndCategory($user, $category)
    {
        $repositoryWeeklytaskUser = $this->objectManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        return $repositoryWeeklytaskUser->findAllByUserAndCategory($user, $category);
    }


}