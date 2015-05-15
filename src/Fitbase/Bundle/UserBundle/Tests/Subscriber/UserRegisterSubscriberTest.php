<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Subscriber;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Consumer\UserRegisterConsumer;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Subscriber\UserSubscriber;

class UserRegisterSubscriberTest extends FitbaseTestAbstract
{
    /**
     * Setup user repository for this test
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRepositoryUser()
    {
        $repository = $this->getMock('UserRepository', array('findByUsername'));
        $repository->expects($this->any())
            ->method('findByUsername')
            ->will($this->returnValue(null));

        return $repository;
    }

    /**
     * get user object for this test
     * @return User
     */
    protected function getUser()
    {
        return (new User())
            ->setActioncode(
                (new UserActioncode())
                    ->setCompany(
                        (new Company())
                    )
            );
    }

    public function testConsumerShouldStoreObject()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->getRepositoryUser()));

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


        $subscriber = new UserSubscriber($entityManager,
            $this->getEventDispatcher(), $this->container()->get('datetime'));
        $subscriber->onUserRegisterEvent(new UserEvent($this->getUser()));

        $this->assertEquals(count($flushed), 2);
        $this->assertEquals(count($persisted), 2);
    }

    public function testConsumerShouldFireEvents()
    {
        $eventDispatcher = $this->getEventDispatcher();

        $events = array();
        $eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnCallback(function ($code, $event) use (&$events) {
                array_push($events, $code);
            }));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->getRepositoryUser()));

        $subscriber = new UserSubscriber($entityManager,
            $this->getEventDispatcher(), $this->container()->get('datetime'));
        $subscriber->onUserRegisterEvent(new UserEvent($this->getUser()));

        $this->assertEquals(count($events), 2);
        $this->assertNotNull(array_search('user_create', $events));
        $this->assertNotNull(array_search('user_registered', $events));
    }
}