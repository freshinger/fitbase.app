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


class UserCompanyChangeConsumer implements ConsumerInterface
{
    public function __construct()
    {
    }

    /**
     * Process message and disable user
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {

    }
}