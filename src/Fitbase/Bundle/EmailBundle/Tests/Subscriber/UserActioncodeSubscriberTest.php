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
use Fitbase\Bundle\EmailBundle\Subscriber\UserActioncodeSubscriber;
use Fitbase\Bundle\EmailBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class UserActioncodeSubscriberTest extends FitbaseTestAbstract
{
    protected $mailer;
    protected $templating;
    protected $translator;

    public function setUp()
    {
        $this->mailer = $this->getMock('Mail', array('mail'));
        $this->mailer->expects($this->any())
            ->method('mail')
            ->will($this->returnValue(true));

        $this->templating = $this->container()->get('templating');
        $this->translator = $this->container()->get('translator');
    }

    /**
     * Setup user actioncode object
     * @return UserActioncode
     */
    protected function getUserActioncode()
    {
        return (new UserActioncode())
            ->setEmail('test@test.com')
            ->setCompany(
                (new Company())
            );
    }

    /**
     * Check that method send email to user
     */
    public function testMethod_onUserActioncodeInviteEvent_ShouldSendEmail()
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


        (new UserActioncodeSubscriber($this->mailer, $this->templating, $this->translator))
            ->onUserActioncodeInviteEvent(
                new UserActioncodeEvent($this->getUserActioncode())
            );

        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertNotEmpty($title);
        $this->assertNotEmpty($content);
    }

} 