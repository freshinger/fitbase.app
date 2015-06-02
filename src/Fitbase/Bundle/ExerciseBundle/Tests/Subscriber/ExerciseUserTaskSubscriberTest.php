<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/02/15
 * Time: 14:54
 */

namespace Fitbase\Bundle\ExerciseBundle\Tests\Subscriber;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserTaskEvent;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserTaskSubscriber;
use Fitbase\Bundle\ExerciseBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class ExerciseUserTaskSubscriberTest extends FitbaseTestAbstract
{

    /**
     * Setup user object for this
     * test only
     * @return User
     */
    protected function getUser()
    {
        return (new User());
    }

    /**
     * Setup exercise user task for this test
     * @return ExerciseUserTask
     */
    protected function getExerciseUserTask()
    {
        return (new ExerciseUserTask());
    }

    public function testOnExerciseUserTaskProcessEventShouldNotMarkAsDone0()
    {
        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
        $persisted = array();
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                array_push($persisted, $entity);
            }));

        $exerciseUserTask = $this->getExerciseUserTask()
            ->setExercise0Done(false)
            ->setExercise1Done(true)
            ->setExercise2Done(true);

        $subscriber = new ExerciseUserTaskSubscriber($entityManager, $datetime);
        $subscriber->onExerciseUserTaskProcessEvent(
            new ExerciseUserTaskEvent($exerciseUserTask)
        );

        $exerciseUserTask = array_shift($persisted);
        $this->assertNull($exerciseUserTask->getDone());
    }


    public function testOnExerciseUserTaskProcessEventShouldMarkAsDone()
    {
        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
        $persisted = array();
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                array_push($persisted, $entity);
            }));

        $exerciseUserTask = $this->getExerciseUserTask()
            ->setExercise0Done(true)
            ->setExercise1Done(true)
            ->setExercise2Done(true);

        $subscriber = new ExerciseUserTaskSubscriber($entityManager, $datetime);
        $subscriber->onExerciseUserTaskProcessEvent(
            new ExerciseUserTaskEvent($exerciseUserTask)
        );

        $exerciseUserTask = array_shift($persisted);
        $this->assertTrue($exerciseUserTask->getDone());
    }

}