<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:45
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\EmailBundle\Subscriber\UserActioncodeSubscriber;
use Fitbase\Bundle\EmailBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class UserActioncodeSubscriberTest extends \PHPUnit_Framework_TestCase
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


        $this->templating = $this->getMock('Templating', array('render'));
        $this->templating->expects($this->any())
            ->method('render')
            ->will($this->returnValue('html content'));


        $this->translator = $this->getMock('Translator', array('trans'));
        $this->translator->expects($this->any())
            ->method('trans')
            ->will($this->returnValue('translation'));
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
            ->onUserActioncodeInviteEvent((new UserActioncodeEvent(
                (new UserActioncode())
                    ->setEmail('test@test.com')
            )));

        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertEquals($title, $this->translator->trans());
        $this->assertEquals($content, $this->templating->render());
    }

} 