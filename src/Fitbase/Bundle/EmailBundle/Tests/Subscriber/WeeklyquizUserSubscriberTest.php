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
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;

class WeeklyquizUserSubscriberTest extends FitbaseTestAbstract
{
    protected $mailer;
    protected $templating;
    protected $translator;
    protected $objectManager;

    /**
     * Get weeklyquiz user object, predefined for current test
     *
     * @return WeeklyquizUser
     */
    protected function getWeeklyquizUser()
    {
        return (new WeeklyquizUser())
            ->setUser($this->getUser());
    }

    /**
     * Get user object for this test
     *
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
     * Get exercise user reminder repository
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getWeeklyquizUserRepository()
    {
        return $this->getMock('WeeklyquizUserRepository', ['exists', 'processed']);
    }


    /**
     * Redefine entity manager object for current test
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEntityManager()
    {
        $entityManager = parent::getEntityManager();

        $entityManager->expects($this->any())
            ->method('persist')->will($this->returnValue(true));

        $entityManager->expects($this->any())
            ->method('flush')->will($this->returnValue(true));

        return $entityManager;
    }

    /**
     * Get mailer object for current test
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMailer()
    {
        $mailer = $this->getMock('Mail', array('mail'));

        $mailer->expects($this->any())
            ->method('mail')->will($this->returnValue(true));

        return $mailer;
    }


    /**
     * Check that method send email to user
     */
    public function testMethod_onWeeklyquizUserSendEvent_ShouldSendEmail()
    {
        $user = null;
        $title = null;
        $content = null;

        $repository = $this->getWeeklyquizUserRepository();
        $repository->expects($this->any())
            ->method('processed')->will($this->returnValue(null));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $mailer = $this->getMailer();
        $mailer->expects($this->any())
            ->method('mail')
            ->will($this->returnCallback(function ($u, $t, $c) use (&$user, &$title, &$content) {
                $user = $u;
                $title = $t;
                $content = $c;
            }));

        $subscriber = new WeeklyquizUserSubscriber(
            $mailer, $this->container()->get('templating'),
            $this->container()->get('translator'), $entityManager
        );

        $subscriber->onWeeklyquizUserSendEvent(
            new WeeklyquizUserEvent($this->getWeeklyquizUser())
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
    public function testMethod_onWeeklyquizUserSendEvent_ShouldNotSendMessageForExistedQuiz()
    {
        $repository = $this->getWeeklyquizUserRepository();
        $repository->expects($this->any())
            ->method('processed')->will($this->returnValue(
                $this->getWeeklyquizUser()
            ));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $event = new WeeklyquizUserEvent(
            $this->getWeeklyquizUser()
        );

        $subscriber = new WeeklyquizUserSubscriber(
            $this->getMailer(), $this->container()->get('templating'),
            $this->container()->get('translator'), $entityManager
        );

        $exception = null;

        try {

            $subscriber->onWeeklyquizUserSendEvent($event);
            $this->assertTrue(false);

        } catch (\Exception $exception) {

        }

        $this->assertTrue($exception instanceof \LogicException);
    }
}