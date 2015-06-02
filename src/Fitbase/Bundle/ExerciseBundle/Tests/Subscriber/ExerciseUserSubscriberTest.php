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
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserTask;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserTaskEvent;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserSubscriber;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserTaskSubscriber;
use Fitbase\Bundle\ExerciseBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

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
        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
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