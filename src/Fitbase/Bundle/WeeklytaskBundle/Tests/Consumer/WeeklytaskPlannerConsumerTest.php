<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Consumer;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\WeeklytaskBundle\Consumer\WeeklytaskPlannerConsumer;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeeklytaskPlannerConsumerTest extends WebTestCase
{
    protected $objectManager;
    protected $datetime;
    protected $eventDispatcher;
    protected $serviceWeeklytask;
    protected $backend;

    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

        $this->datetime = $this->container()->get('datetime');
        $this->backend = $this->getMock('Backend', array('createAndPublish'));

        $this->objectManager = $this->getMock('ObjectManager', array('persist', 'flush'));
        $this->eventDispatcher = $this->getMock('EventDispatcher', array('dispatch'));

        $this->serviceWeeklytask = $this->getMock('Weeklytask', array('isExists', 'create', 'isLast', 'getLast'));
        $this->serviceWeeklytask->expects($this->any())
            ->method('isExists')
            ->will($this->returnValue(false));
        $this->serviceWeeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnValue(true));
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
    public function testMethodConsumerShouldCreatePlan()
    {
        $processedUser = null;
        $processedDatetime = null;

        $this->serviceWeeklytask->expects($this->any())
            ->method('isLast')
            ->will($this->returnValue(true));

        $this->serviceWeeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function ($user, $datetime) use (&$processedUser, &$processedDatetime) {
                $processedUser = $user;
                $processedDatetime = $datetime;
            }));

        $consumer = new WeeklytaskPlannerConsumer($this->objectManager, $this->eventDispatcher,
            $this->datetime, $this->serviceWeeklytask, $this->backend);

        $message = new Message();
        $message->setBody(array(
            'item' => (new ReminderUserItem())
                ->setUser(
                    (new User())
                )
                ->setTime(new \DateTime('now'))
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertTrue($processedUser instanceof User);
        $this->assertTrue($processedDatetime instanceof \DateTime);
    }


    /**
     * Run last weeklytask process
     *
     */
    public function testMethodConsumerShouldRunLast()
    {
        $processedCode = null;
        $processedMessage = null;

        $this->backend->expects($this->any())
            ->method('createAndPublish')
            ->will($this->returnCallback(function ($code, $message) use (&$processedCode, &$processedMessage) {
                $processedCode = $code;
                $processedMessage = $message;
            }));

        $this->serviceWeeklytask->expects($this->any())
            ->method('isLast')
            ->will($this->returnValue(true));

        $this->serviceWeeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnValue(true));

        $consumer = new WeeklytaskPlannerConsumer($this->objectManager, $this->eventDispatcher,
            $this->datetime, $this->serviceWeeklytask, $this->backend);

        $message = new Message();
        $message->setBody(array(
            'item' => (new ReminderUserItem())
                ->setUser(
                    (new User())
                )
                ->setTime(new \DateTime('now'))
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertEquals($processedCode, 'weeklytask_last');
        $this->assertTrue(array_key_exists('user', $processedMessage));
    }

    /**
     * Check consumer should not
     * run last weeklytask if it does not last
     */
    public function testMethodConsumerShouldNotRunLast()
    {
        $processedCode = null;
        $processedMessage = null;

        $this->backend->expects($this->any())
            ->method('createAndPublish')
            ->will($this->returnCallback(function ($code, $message) use (&$processedCode, &$processedMessage) {
                $processedCode = $code;
                $processedMessage = $message;
            }));

        $this->serviceWeeklytask->expects($this->any())
            ->method('isLast')
            ->will($this->returnValue(false));

        $this->serviceWeeklytask->expects($this->any())
            ->method('create')
            ->will($this->returnValue(true));

        $consumer = new WeeklytaskPlannerConsumer($this->objectManager, $this->eventDispatcher,
            $this->datetime, $this->serviceWeeklytask, $this->backend);

        $message = new Message();
        $message->setBody(array(
            'item' => (new ReminderUserItem())
                ->setUser(
                    (new User())
                )
                ->setTime(new \DateTime('now'))
        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertEquals($processedCode, null);
        $this->assertEquals($processedMessage, null);
    }
}