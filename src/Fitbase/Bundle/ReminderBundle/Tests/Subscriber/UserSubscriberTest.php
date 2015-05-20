<?php

namespace Fitbase\Bundle\ReminderBundle\Tests\Subscriber;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserSubscriberTest extends FitbaseTestAbstract
{

    /**
     * get user object for this test
     * @return User
     */
    protected function getUser()
    {
        return (new User())
            ->addReminder(
                (new ReminderUser())
            )
            ->setActioncode(
                (new UserActioncode())
                    ->setCompany(
                        (new Company())
                    )
            );
    }

    public function testOnUserRemovePrepareEventShouldPauseFitbase()
    {
        $subscriber = new UserSubscriber(
            $this->getEntityManager(),
            $this->container()->get('datetime')
        );

        $event = new UserEvent($this->getUser());
        $subscriber->onUserRemovePrepareEvent($event);

        $this->assertTrue(true);

        $this->assertEquals($event->getEntity()->getReminder()->getPause(), 2);
        $this->assertFalse($event->getEntity()->getReminder()->getUpdate());
        $this->assertNotEmpty($event->getEntity()->getReminder()->getPauseStart());
    }

    public function testOnUserRemoveRecoverEventShouldEnableFitbase()
    {
        $subscriber = new UserSubscriber(
            $this->getEntityManager(),
            $this->container()->get('datetime')
        );

        $event = new UserEvent($this->getUser());
        $subscriber->onUserRemoveRecoverEvent($event);

        $this->assertTrue(true);

        $this->assertEmpty($event->getEntity()->getReminder()->getPause());
        $this->assertEmpty($event->getEntity()->getReminder()->getUpdate());
        $this->assertEmpty($event->getEntity()->getReminder()->getPauseStart());
    }

}