<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\UserBundle\Consumer;

use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Symfony\Component\HttpFoundation\Response;


class WeeklytaskExpireConsumer implements ConsumerInterface
{
    protected $datetime;
    protected $objectManager;
    protected $serviceWeeklytask;

    public function __construct($objectManager, $datetime, $serviceWeeklytask)
    {
        $this->datetime = $datetime;
        $this->objectManager = $objectManager;
        $this->serviceWeeklytask = $serviceWeeklytask;
    }

    /**
     * Process message and disable user
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
        if (($message = $event->getMessage())) {
            if (($user = $message->getValue('user'))) {
                if (($actioncode = $user->getActioncode()) and $actioncode->getExpire()) {

                    $date = $this->datetime->getDateTime('now');
                    if (($weeklytaskUser = $this->serviceWeeklytask->getLast($user))) {
                        if (($interval = $date->diff($weeklytaskUser->getDate()))) {
                            // Check a difference between last weeklytask
                            // and current date, if that bigger than one week
                            // expire a user account
                            if (((int)$interval->format('%a')) >= 7) {

                                $user->setExpired(true);

                                $this->objectManager->persist($user);
                                $this->objectManager->flush($user);
                            }
                        }
                    }
                }
            }
        }
    }
}