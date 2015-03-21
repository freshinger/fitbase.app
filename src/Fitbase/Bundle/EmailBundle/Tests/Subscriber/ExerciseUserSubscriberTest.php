<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:08
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Subscriber;


use Application\Sonata\ClassificationBundle\Document\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\EmailBundle\Subscriber\ExerciseUserSubscriber;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;

class ExerciseUserSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $mailer;
    protected $objectManager;
    protected $chooserCategory;
    protected $templating;
    protected $translator;


    public function setUp()
    {
        // Create a stub for the SomeClass class.
        $this->mailer = $this->getMock('Mail', array('mail'));
        // Configure the stub.
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


        $this->chooserCategory = $this->getMock('Chooser', array('choose'));
        $this->chooserCategory->expects($this->any())
            ->method('choose')
            ->will($this->returnValue(array(
                new Category(), new Category()
            )));


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
     *
     */
    public function testMethodOnExerciseUserSendEventShouldSendEmail()
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

        $subscriber = new ExerciseUserSubscriber($this->mailer, $this->templating,
            $this->translator, $this->objectManager, $this->chooserCategory);


        $event = new ExerciseUserEvent(
            (new ExerciseUser())
                ->setUser(
                    (new User())
                        ->setEmail('test@test.com')
                        ->setFocus((new UserFocus()))
                )
        );

        $subscriber->onExerciseUserSendEvent($event);

        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertEquals($title, $this->translator->trans());
        $this->assertEquals($content, $this->templating->render());
    }

    /**
     * Test that method should
     * change processed status for ExerciseUser
     *
     */
    public function testMethodOnExerciseUserSendEventShouldMarkExerciseAsProcessed()
    {
        $subscriber = new ExerciseUserSubscriber($this->mailer, $this->templating,
            $this->translator, $this->objectManager, $this->chooserCategory);

        $event = new ExerciseUserEvent(
            (new ExerciseUser())
                ->setUser(
                    (new User())
                        ->setEmail('test@test.com')
                        ->setFocus((new UserFocus()))
                )
        );

        $subscriber->onExerciseUserSendEvent($event);

        $this->assertEquals($event->getEntity()->getProcessed(), 1);
    }

} 