<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 15:45
 */
namespace Fitbase\Bundle\UserBundle\Test\Consumer;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\WeeklytaskBundle\Consumer\WeeklytaskCreatorConsumer;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeeklytaskCreatorConsumerTest extends WebTestCase
{
    protected $objectManager;
    protected $datetime;
    protected $codegenerator;

    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

        $this->datetime = $this->container()->get('datetime');
        $this->codegenerator = $this->container()->get('codegenerator');

        $this->objectManager = $this->getMock('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskManagerInterface', array(
            'persist', 'exists', 'findOneByUserAndUnique', 'findAllByUserAndCategory'
        ));

        $this->objectManager->expects($this->any())
            ->method('persist')->will($this->returnValue(true));

        $this->objectManager->expects($this->any())
            ->method('findOneByUserAndUnique')->will($this->returnValue(true));

        $this->objectManager->expects($this->any())
            ->method('findAllByUserAndCategory')->will($this->returnValue(true));

    }

    protected function container(array $options = array(), array $server = array())
    {
        static::bootKernel($options);
        return static::$kernel->getContainer();
    }


    /**
     * Check that method create
     * a new weeklytask user object
     */
    public function testMethodConsumerShouldCreateWeeklytaskUser()
    {
        $processedObject = null;
        $this->objectManager->expects($this->any())
            ->method('persist')->will($this->returnCallback(function ($object) use (&$processedObject) {
                $processedObject = $object;
            }));


        $this->objectManager->expects($this->any())
            ->method('exists')->will($this->returnValue(false));


        $consumer = new WeeklytaskCreatorConsumer($this->objectManager,
            $this->datetime, $this->codegenerator);


        $message = new Message();
        $message->setBody(array(
            'user' => (new User()),
            'weeklytask' => (new Weeklytask()),
            'processed' => true,
            'date' => new \DateTime('now'),

        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertTrue($processedObject instanceof WeeklytaskUser);
    }

    /**
     * Check that method have not to create
     * a new weeklytask user object
     *
     */
    public function testMethodConsumerShouldNotCreateWeeklytaskUserIfExists()
    {
        $processedObject = null;
        $this->objectManager->expects($this->any())
            ->method('persist')->will($this->returnCallback(function ($object) use (&$processedObject) {
                $processedObject = $object;
            }));

        $this->objectManager->expects($this->any())
            ->method('exists')->will($this->returnValue(true));


        $consumer = new WeeklytaskCreatorConsumer($this->objectManager,
            $this->datetime, $this->codegenerator);


        $message = new Message();
        $message->setBody(array(
            'user' => (new User()),
            'weeklytask' => (new Weeklytask()),
            'processed' => true,
            'date' => new \DateTime('now'),

        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertEquals($processedObject, null);
    }

    /**
     * Check that method have to create
     * weeklytask user object and weeklyquiz user object
     *
     */
    public function testMethodConsumerShouldCreateWeeklyquizUser()
    {
        $processedObject = array();
        $this->objectManager->expects($this->any())
            ->method('persist')->will($this->returnCallback(function ($object) use (&$processedObject) {
                array_push($processedObject, $object);
            }));


        $this->objectManager->expects($this->any())
            ->method('exists')->will($this->returnValue(false));

        $consumer = new WeeklytaskCreatorConsumer($this->objectManager,
            $this->datetime, $this->codegenerator);


        $message = new Message();
        $message->setBody(array(
            'user' => (new User()),
            'weeklytask' => (new Weeklytask())->setQuiz((new Weeklyquiz())),
            'processed' => true,
            'date' => new \DateTime('now'),

        ));

        $consumer->process(new ConsumerEvent($message));

        $this->assertEquals(count($processedObject), 3);

        $this->assertTrue($processedObject[0] instanceof WeeklytaskUser);
        $this->assertTrue($processedObject[1] instanceof WeeklyquizUser);
        $this->assertTrue($processedObject[2] instanceof WeeklytaskUser);
    }

}