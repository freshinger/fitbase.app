<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Subscriber;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Consumer\UserRegisterConsumer;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Subscriber\UserSubscriber;
use ReflectionMethod;

class UserSubscriberTest extends FitbaseTestAbstract
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

    /**
     * Setup user focus category
     *
     * @return UserFocus
     */
    protected function getUserFocus()
    {
        $category1 = new Category();
        $category1->setSlug('oberer-ruecken');

        $category2 = new Category();
        $category2->setSlug('unterer-ruecken');

        $category3 = new Category();
        $category3->setSlug('mittlerer-ruecken');

        return (new UserFocus())
            ->addCategory(
                (new UserFocusCategory())
                    ->setCategory($category1)
            )
            ->addCategory(
                (new UserFocusCategory())
                    ->setCategory($category2)
            )
            ->addCategory(
                (new UserFocusCategory())
                    ->setCategory($category3)
            );
    }

    /**
     * @return UserFocusCategory
     */
    protected function getUserFocusCategory()
    {
        $category = new Category();
        $category->setSlug('ruecken');

        return (new UserFocusCategory())
            ->setCategory($category);
    }

    public function testDoAppendFocusSettingsDefaultShouldSetCorrectType()
    {
        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
        $eventDispatcher = $this->getEventDispatcher();

        $subscriber = new UserSubscriber($entityManager, $eventDispatcher, $datetime);

        $method = new ReflectionMethod($subscriber, 'doAppendFocusSettingsDefault');
        $method->setAccessible(true);

        $userFocus = $this->getUserFocus();
        $userFocusCategory = $this->getUserFocusCategory();

        $method->invoke($subscriber, $userFocus, $userFocusCategory);

        $this->assertEquals($userFocusCategory->getType(), 0);
    }

    public function testDoAppendFocusSettingsDefaultShouldAppendCategories()
    {
        $datetime = $this->container()->get('datetime');
        $entityManager = $this->getEntityManager();
        $eventDispatcher = $this->getEventDispatcher();

        $subscriber = new UserSubscriber($entityManager, $eventDispatcher, $datetime);

        $method = new ReflectionMethod($subscriber, 'doAppendFocusSettingsDefault');
        $method->setAccessible(true);

        $userFocus = $this->getUserFocus();
        $userFocusCategory = $this->getUserFocusCategory();

        $method->invoke($subscriber, $userFocus, $userFocusCategory);

        $this->assertEquals(count($userFocusCategory->getPrimaries()), 3);
    }


    public function testOnUserRemoveEventShouldRemoveUser()
    {
        $entityManager = $this->getEntityManager();

        $removed = array();
        $entityManager->expects($this->any())
            ->method('remove')
            ->will($this->returnCallback(function ($entity) use (&$removed) {
                array_push($removed, $entity);
            }));

        $subscriber = new UserSubscriber($entityManager,
            $this->getEventDispatcher(), $this->container()->get('datetime'));
        $subscriber->onUserRemoveEvent(new UserEvent($this->getUser()));

        $this->assertEquals(count($removed), 1);
    }

    public function testOnUserRemoveEventShouldFlushRemovedUser()
    {
        $entityManager = $this->getEntityManager();

        $flushed = array();
        $entityManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($entity) use (&$flushed) {
                array_push($flushed, $entity);
            }));

        $subscriber = new UserSubscriber($entityManager,
            $this->getEventDispatcher(), $this->container()->get('datetime'));
        $subscriber->onUserRemoveEvent(new UserEvent($this->getUser()));

        $this->assertEquals(count($flushed), 1);
    }


    public function testOnUserRemovePrepareEventShouldSetRemoveRequestAsTrue()
    {
        $subscriber = new UserSubscriber($this->getEntityManager(),
            $this->getEventDispatcher(), $this->container()->get('datetime'));

        $event = new UserEvent($this->getUser());
        $subscriber->onUserRemovePrepareEvent($event);


        $this->assertTrue($event->getEntity() instanceof User);
        $this->assertTrue($event->getEntity()->getRemoveRequest());
        $this->assertNotEmpty($event->getEntity()->getRemoveRequestAt());
    }


    public function testOnUserRemovePrepareEventShouldSetRemoveRequestAsNull()
    {
        $subscriber = new UserSubscriber($this->getEntityManager(),
            $this->getEventDispatcher(), $this->container()->get('datetime'));

        $event = new UserEvent($this->getUser());
        $subscriber->onUserRemoveRecoverEvent($event);

        $this->assertTrue($event->getEntity() instanceof User);
        $this->assertEmpty($event->getEntity()->getRemoveRequest());
        $this->assertEmpty($event->getEntity()->getRemoveRequestAt());
    }
}