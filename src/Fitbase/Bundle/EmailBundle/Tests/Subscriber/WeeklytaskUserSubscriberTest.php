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
use Fitbase\Bundle\EmailBundle\Subscriber\WeeklytaskUserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;

class WeeklytaskUserSubscriberTest extends FitbaseTestAbstract
{
    protected $mailer;
    protected $templating;
    protected $translator;
    protected $objectManager;


    /**
     * Get user object for this test
     * @return User
     */
    protected function getUser()
    {
        return (new User())
            ->setCompany(new Company())
            ->setEmail('test@test.com')
            ->setFocus(new UserFocus());
    }

    /**
     * Get weeklyquiz user object, predefined for current test
     *
     * @return WeeklyquizUser
     */
    protected function getWeeklytaskUser()
    {
        return (new WeeklytaskUser())
            ->setTask(new Weeklytask())
            ->setUser($this->getUser());
    }

    /**
     * Get exercise user reminder repository
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getWeeklytaskUserRepository()
    {
        return $this->getMock('WeeklytaskUserRepository', array('exists', 'processed'));
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
     * Check that method send email to user
     */
    public function testMethod_onWeeklytaskUserSendEvent_ShouldSendEmail()
    {

        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())->method('processed')
            ->will($this->returnValue(null));

        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));


        $user = null;
        $title = null;
        $content = null;

        $mailer = $this->getMailer();
        $mailer->expects($this->any())
            ->method('mail')->will($this->returnCallback(function ($u, $t, $c) use (&$user, &$title, &$content) {
                $user = $u;
                $title = $t;
                $content = $c;
            }));

        $translator = $this->container()->get('translator');
        $templating = $this->container()->get('templating');

        $subscriber = new WeeklytaskUserSubscriber(
            $mailer, $templating,
            $translator, $entityManager
        );

        $subscriber->onWeeklytaskUserSendEvent(
            new WeeklytaskUserEvent($this->getWeeklytaskUser())
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
    public function testMethod_onWeeklytaskUserSendEvent_ShouldThrowException()
    {

        $repository = $this->getWeeklytaskUserRepository();
        $repository->expects($this->any())->method('processed')
            ->will($this->returnValue(
                $this->getWeeklytaskUser()
            ));

        $mailer = $this->getMailer();
        $translator = $this->container()->get('translator');
        $templating = $this->container()->get('templating');
        $entityManager = $this->getEntityManager();
        $entityManager->expects($this->any())
            ->method('getRepository')->will($this->returnValue($repository));

        $subscriber = new WeeklytaskUserSubscriber(
            $mailer, $templating,
            $translator, $entityManager
        );

        $exception = null;

        try {

            $subscriber->onWeeklytaskUserSendEvent(
                new WeeklytaskUserEvent($this->getWeeklytaskUser())
            );

        } catch (\Exception $exception) {

        }

        $this->assertTrue($exception instanceof \LogicException);
    }
}