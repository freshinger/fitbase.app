<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:45
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\EmailBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\EmailBundle\Subscriber\WeeklyquizUserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;

class WeeklyquizUserSubscriberTest extends FitbaseTestAbstract
{
    protected $mailer;
    protected $templating;
    protected $translator;
    protected $objectManager;

    public function setUp()
    {
        $this->mailer = $this->getMock('Mail', array('mail'));
        $this->mailer->expects($this->any())
            ->method('mail')
            ->will($this->returnValue(true));

        $this->objectManager = $this->getMock('EntityManager', array('persist', 'flush'));
        $this->objectManager->expects($this->any())
            ->method('persist')
            ->will($this->returnValue('true'));
        $this->objectManager->expects($this->any())
            ->method('flush')
            ->will($this->returnValue('true'));

        $this->templating = $this->container()->get('templating');
        $this->translator = $this->container()->get('translator');
    }


    /**
     * Get user object for this test
     * @return User
     */
    protected function getUser()
    {
        return (new User())
            ->setCompany(
                (new Company())
            )
            ->setEmail('test@test.com')
            ->setFocus(
                (new UserFocus())
            );
    }


    /**
     * Check that method send email to user
     */
    public function testMethod_onWeeklyquizUserSendEvent_ShouldSendEmail()
    {
        $user = null;
        $title = null;
        $content = null;

        // Configure the stub.
        $this->mailer->expects($this->any())
            ->method('mail')
            ->will($this->returnCallback(function ($u, $t, $c) use (&$user, &$title, &$content) {
                $user = $u;
                $title = $t;
                $content = $c;
            }));


        (new WeeklyquizUserSubscriber($this->mailer, $this->templating, $this->translator, $this->objectManager))
            ->onWeeklyquizUserSendEvent(
                new WeeklyquizUserEvent(
                    (new WeeklyquizUser())
                        ->setUser($this->getUser())
                )
            );

        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertNotEmpty($title);
        $this->assertNotEmpty($content);
    }

    /**
     * Check that weeklyquiz status
     * was changed after email-sending
     *
     */
    public function testMethod_onWeeklyquizUserSendEvent_ShouldChangeProcessed()
    {
        $event = new WeeklyquizUserEvent(
            (new WeeklyquizUser())
                ->setUser($this->getUser())
        );

        (new WeeklyquizUserSubscriber($this->mailer, $this->templating, $this->translator, $this->objectManager))
            ->onWeeklyquizUserSendEvent($event);

        $this->assertEquals($event->getEntity()->getProcessed(), 1);
    }
}