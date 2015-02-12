<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Consumer;

use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Symfony\Component\HttpFoundation\Response;


class WeeklytaskPlannerConsumer implements ConsumerInterface
{
    protected $objectManager;
    protected $datetime;
    protected $eventDispatcher;
    protected $serviceWeeklytask;
    protected $backend;

    public function __construct($objectManager, $eventDispatcher, $datetime, $serviceWeeklytask, $backend)
    {
        $this->objectManager = $objectManager;
        $this->datetime = $datetime;
        $this->eventDispatcher = $eventDispatcher;
        $this->serviceWeeklytask = $serviceWeeklytask;
        $this->backend = $backend;
    }

    /**
     *
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
        if (($message = $event->getMessage())) {
            if (($item = $message->getValue('item'))) {
                if (($user = $item->getUser())) {

                    $hour = $item->getTime()->format('H');
                    $minute = $item->getTime()->format('i');

                    $datetime = $this->datetime->getDateTime('now');
                    $datetime->setTime($hour, $minute);

                    // Check is weeklytask for this date
                    // already exists break up a scenario
                    if (!$this->serviceWeeklytask->isExists($user, $datetime)) {
                        // Try to create a new weeklytask for this user
                        // and this date, if task has been created,
                        // break up a scenario
                        $this->serviceWeeklytask->create($user, $datetime);
                    }

                    if ($this->serviceWeeklytask->isLast($user, $datetime)) {
                        // Check is a last weeklytask was already sent
                        // for current user, than create a event that
                        // a last weeklytask was sent
                        $this->backend->createAndPublish('weeklytask_last', array(
                            'user' => $user,
                        ));
                    }


                }
            }
        }
    }
}