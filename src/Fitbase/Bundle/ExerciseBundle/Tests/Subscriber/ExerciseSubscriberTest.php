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
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserTaskEvent;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseSubscriber;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserSubscriber;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserTaskSubscriber;
use Fitbase\Bundle\ExerciseBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class ExerciseSubscriberTest extends FitbaseTestAbstract
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
    protected function getExercise()
    {
        return (new Exercise());
    }

    /**
     * Check that ExerciseUser object
     * will marked as done
     *
     */
    public function testOnExerciseProcessEventShouldFireEvent()
    {
        $datetime = $this->container()->get('datetime');
        $eventDispatcher = $this->getEventDispatcher();
        $serviceUser = $this->getMock('ServiceUser', array('current'));
        $serviceUser->expects($this->any())
            ->method('current')
            ->will($this->returnValue($this->getUser()));

        $code = null;
        $event = null;
        $eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnCallback(function ($eventCode, $eventObject) use (&$code, &$event) {
                $code = $eventCode;
                $event = $eventObject;
            }));

        $subscriber = new ExerciseSubscriber($eventDispatcher, $serviceUser, $datetime);
        $subscriber->onExerciseProcessEvent(
            new ExerciseEvent($this->getExercise())
        );

        $this->assertEquals($code, 'fitbase.exercise_user_process');
        $this->assertTrue($event instanceof ExerciseUserEvent);
    }


    public function testOnExerciseProcessEventShouldFireEventWithCorrectObject()
    {
        $datetime = $this->container()->get('datetime');
        $eventDispatcher = $this->getEventDispatcher();
        $serviceUser = $this->getMock('ServiceUser', array('current'));
        $serviceUser->expects($this->any())
            ->method('current')
            ->will($this->returnValue($this->getUser()));

        $code = null;
        $event = null;
        $eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnCallback(function ($eventCode, $eventObject) use (&$code, &$event) {
                $code = $eventCode;
                $event = $eventObject;
            }));

        $subscriber = new ExerciseSubscriber($eventDispatcher, $serviceUser, $datetime);
        $subscriber->onExerciseProcessEvent(
            new ExerciseEvent($this->getExercise())
        );

        $this->assertTrue($event->getEntity()->getDone());
        $this->assertTrue($event->getEntity()->getProcessed());
        $this->assertNotNull($event->getEntity()->getUser());
        $this->assertNotNull($event->getEntity()->getExercise());
        $this->assertNotNull($event->getEntity()->getDate());
        $this->assertNotNull($event->getEntity()->getDoneDate());
        $this->assertNotNull($event->getEntity()->getProcessedDate());


    }

}