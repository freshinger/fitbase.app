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

    public function testMethodOnUserRegisteredEventShouldStoreExerciseObject()
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

        $subscriber = new UserSubscriber($entityManager, $this->container()->get('datetime'));

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

        $subscriber = new UserSubscriber($entityManager, $this->container()->get('datetime'));

        $subscriber->onUserRegisteredEvent(new UserEvent($this->getUser()));

        $exercise = array_shift($flushed);
        $this->assertEquals($exercise->getDone(), true);
        $this->assertEquals($exercise->getProcessed(), true);

    }

}