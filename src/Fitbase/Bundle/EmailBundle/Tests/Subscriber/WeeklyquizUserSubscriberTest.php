<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:45
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\EmailBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\EmailBundle\Subscriber\WeeklyquizUserSubscriber;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;

class WeeklyquizUserSubscriberTest extends \PHPUnit_Framework_TestCase
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
            ->onWeeklyquizUserSendEvent(new WeeklyquizUserEvent(
                (new WeeklyquizUser())
                    ->setUser(
                        (new User())
                            ->setEmail('test@test.com')
                    )
            ));

        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertEquals($title, $this->translator->trans());
        $this->assertEquals($content, $this->templating->render());
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
                ->setUser(
                    (new User())
                        ->setEmail('test@test.com')
                )
        );

        (new WeeklyquizUserSubscriber($this->mailer, $this->templating, $this->translator, $this->objectManager))
            ->onWeeklyquizUserSendEvent($event);

        $this->assertEquals($event->getEntity()->getProcessed(), 1);
    }
}