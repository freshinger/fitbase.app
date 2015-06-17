<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/02/15
 * Time: 14:54
 */

namespace Fitbase\Bundle\ExerciseBundle\Tests\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class ExerciseUserSubscriberTest extends FitbaseTestAbstract
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
    protected function getExerciseUser()
    {
        return (new ExerciseUser());
    }

    /**
     * Check that ExerciseUser object
     * will marked as done
     *
     */
    public function testOnExerciseUserTaskProcessEventShouldMarkAsDone()
    {
        $repository = $this->getMock('Repository', ['exists']);
        $repository->expects($this->any())
            ->method('exists')
            ->will($this->returnValue(null));

        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));

        $persisted = array();
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                array_push($persisted, $entity);
            }));


        $subscriber = new ExerciseUserSubscriber($entityManager, $datetime);
        $subscriber->onExerciseUserProcessEvent(
            new ExerciseUserEvent($this->getExerciseUser())
        );

        $exerciseUser = array_shift($persisted);
        $this->assertTrue($exerciseUser->getDone());
        $this->assertNotNull($exerciseUser->getDoneDate());
    }


}