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
use Fitbase\Bundle\ExerciseBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class UserSubscriberTest extends FitbaseTestAbstract
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
     * Get reminder service mock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getServiceReminder()
    {
        $reminder = $this->getMock('ServiceReminder', ['getItemsExercise']);

        $reminder->expects($this->any())
            ->method('getItemsExercise')
            ->will($this->returnValue([
                (new ReminderUserItem())
                    ->setTime(new \DateTime())
                    ->setUser($this->getUser())
            ]));

        return $reminder;
    }


    public function testMethodOnUserRegisteredEventShouldStoreExerciseUserObject()
    {
        $entityManager = $this->getEntityManager();

        $persisted = array();
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                array_push($persisted, $entity);
            }));

        $flushed = array();
        $entityManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($entity) use (&$flushed) {
                array_push($flushed, $entity);
            }));

        $reminder = $this->getServiceReminder();

        $subscriber = new UserSubscriber($entityManager, $this->container()->get('datetime'), $reminder);

        $subscriber->onUserRegisteredEvent(new UserEvent($this->getUser()));

        $this->assertEquals(count($persisted), 1);
        $this->assertEquals(count($flushed), 1);
    }

    public function testMethodOnUserRegisteredEventShouldSetCorrectValues()
    {
        $entityManager = $this->getEntityManager();

        $flushed = array();
        $entityManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($entity) use (&$flushed) {
                array_push($flushed, $entity);
            }));

        $reminder = $this->getServiceReminder();


        $subscriber = new UserSubscriber($entityManager, $this->container()->get('datetime'), $reminder);

        $subscriber->onUserRegisteredEvent(new UserEvent($this->getUser()));

        $exercise = array_shift($flushed);
        $this->assertEquals($exercise->getProcessed(), true);

    }

}