<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:08
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Subscriber;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\EmailBundle\Subscriber\ExerciseUserSubscriber;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;

class ExerciseUserSubscriberTest extends FitbaseTestAbstract
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
                (new Category()), (new Category())
            )));

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


        $event = new ExerciseUserReminderEvent(
            (new ExerciseUserReminder())
                ->setUser($this->getUser())
        );

        $subscriber->onExerciseUserReminderProcessEvent($event);

        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertNotEmpty($title);
        $this->assertNotEmpty($content);
    }
}