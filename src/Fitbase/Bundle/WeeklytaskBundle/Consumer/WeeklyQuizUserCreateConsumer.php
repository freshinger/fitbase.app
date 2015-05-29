<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Consumer;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskManagerInterface;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;


class WeeklytaskUserCreateConsumer implements ConsumerInterface
{
    public function __construct()
    {
    }

    /**
     * Create weeklytask for user, and weeklyquiz
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
    }
}