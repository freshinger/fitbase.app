<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Consumer;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\UserBundle\Consumer\WeeklytaskExpireConsumer;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeeklytaskExpireConsumerTest extends WebTestCase
{
    protected $datetime;
    protected $objectManager;
    protected $serviceWeeklytask;

    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

        $this->datetime = $this->container()->get('datetime');

        $this->objectManager = $this->getMock('EntityManager', array('persist', 'flush'));
        $this->objectManager->expects($this->any())
            ->method('persist')
            ->will($this->returnValue('true'));

        $this->serviceWeeklytask = $this->getMock('Weeklytask', array('getLast'));
    }

    protected function container(array $options = array(), array $server = array())
    {
        static::bootKernel($options);
        return static::$kernel->getContainer();
    }


    /**
     * Check that method create a plan
     * for user
     */
    public function testMethodConsumerShouldFlushUser()
    {
        $processedUser = null;

        $this->objectManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($user) use (&$processedUser) {
                $processedUser = $user;
            }));

        $this->serviceWeeklytask->expects($this->any())
            ->method('getLast')
            ->will($this->returnValue(
                (new WeeklytaskUser())
                    ->setDate(new \DateTime('-8 days'))
            ));


        $consumer = new WeeklytaskExpireConsumer($this->objectManager,
            $this->datetime, $this->serviceWeeklytask);

        $message = new Message();
        $message->setBody(array(
            'user' => (new User())
                ->setActioncode(
                    (new UserActioncode())
                        ->setExpire(1)
                )
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertTrue($processedUser instanceof User);
    }

    /**
     * Check is user marked as expired
     */
    public function testMethodConsumerShouldExpireUser()
    {
        $processedUser = null;

        $this->objectManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($user) use (&$processedUser) {
                $processedUser = $user;
            }));

        $this->serviceWeeklytask->expects($this->any())
            ->method('getLast')
            ->will($this->returnValue(
                (new WeeklytaskUser())
                    ->setDate(new \DateTime('-8 days'))
            ));


        $consumer = new WeeklytaskExpireConsumer($this->objectManager,
            $this->datetime, $this->serviceWeeklytask);

        $message = new Message();
        $message->setBody(array(
            'user' => (new User())
                ->setActioncode(
                    (new UserActioncode())
                        ->setExpire(1)
                )
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertTrue($processedUser instanceof User);
        $this->assertTrue($processedUser->isExpired());
    }

    /**
     * Check that user should be processed
     * after one week
     */
    public function testMethodConsumerShouldNotBeProcessed()
    {
        $processedUser = null;

        $this->objectManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($user) use (&$processedUser) {
                $processedUser = $user;
            }));

        $this->serviceWeeklytask->expects($this->any())
            ->method('getLast')
            ->will($this->returnValue(
                (new WeeklytaskUser())
                    ->setDate(new \DateTime('-1 days'))
            ));

        $consumer = new WeeklytaskExpireConsumer($this->objectManager,
            $this->datetime, $this->serviceWeeklytask);

        $message = new Message();
        $message->setBody(array(
            'user' => (new User())
                ->setActioncode(
                    (new UserActioncode())
                        ->setExpire(1)
                )
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertFalse($processedUser instanceof User);
    }

    /**
     * Check that user would not be expired
     * if actioncode does not have a flag
     */
    public function testMethodConsumerShouldNotBeProcessedIfNoActioncodeExpireFlag()
    {
        $processedUser = null;

        $this->objectManager->expects($this->any())
            ->method('flush')
            ->will($this->returnCallback(function ($user) use (&$processedUser) {
                $processedUser = $user;
            }));

        $this->serviceWeeklytask->expects($this->any())
            ->method('getLast')
            ->will($this->returnValue(
                (new WeeklytaskUser())
                    ->setDate(new \DateTime('-8 days'))
            ));

        $consumer = new WeeklytaskExpireConsumer($this->objectManager,
            $this->datetime, $this->serviceWeeklytask);

        $message = new Message();
        $message->setBody(array(
            'user' => (new User())
                ->setActioncode(
                    (new UserActioncode())
                        ->setExpire(false)
                )
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertFalse($processedUser instanceof User);
    }
}