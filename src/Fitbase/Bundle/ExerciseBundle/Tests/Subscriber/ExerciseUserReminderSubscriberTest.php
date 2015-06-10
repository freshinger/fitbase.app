<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 01/06/15
 * Time: 13:47
 */

namespace Fitbase\Bundle\ExerciseBundle\Tests\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Subscriber\ExerciseUserReminderSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class ExerciseUserReminderSubscriberTest extends FitbaseTestAbstract
{
    /**
     * Get exercise user reminder object
     * @return ExerciseUserReminder
     */
    protected function getExerciseUserReminder()
    {
        return (new ExerciseUserReminder());
    }

    /**
     * Get exercise user reminder repository
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getExerciseUserReminderRepository()
    {
        return $this->getMock('ExerciseUserReminderRepository', array('exists'));
    }

    public function testOnExerciseUserReminderCreateEventShouldNotCreateReminder()
    {
        $repository = $this->getExerciseUserReminderRepository();
        $repository->expects($this->any())->method('exists')
            ->will($this->returnValue($this->getExerciseUserReminder()));


        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));

        $persisted = array();
        $entityManager->expects($this->any())->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                array_push($persisted, $entity);
            }));

        $subscriber = new ExerciseUserReminderSubscriber($entityManager, $datetime);
        $subscriber->onExerciseUserReminderCreateEvent(
            new ExerciseUserReminderEvent(
                $this->getExerciseUserReminder()
            )
        );

        $this->assertEquals(count($persisted), 0);
    }

    public function testOnExerciseUserReminderCreateEventShouldCreateReminder()
    {
        $repository = $this->getExerciseUserReminderRepository();
        $repository->expects($this->any())->method('exists')
            ->will($this->returnValue(null));


        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));

        $persisted = array();
        $entityManager->expects($this->any())->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                array_push($persisted, $entity);
            }));

        $subscriber = new ExerciseUserReminderSubscriber($entityManager, $datetime);
        $subscriber->onExerciseUserReminderCreateEvent(
            new ExerciseUserReminderEvent(
                $this->getExerciseUserReminder()
            )
        );

        $this->assertEquals(count($persisted), 1);
        $this->assertTrue(array_shift($persisted) instanceof ExerciseUserReminder);
    }
}