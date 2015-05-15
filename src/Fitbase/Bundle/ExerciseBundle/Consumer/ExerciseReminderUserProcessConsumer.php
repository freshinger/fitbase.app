<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 13/05/15
 * Time: 15:35
 */
namespace Fitbase\Bundle\ExerciseBundle\Consumer;

use Sonata\NotificationBundle\Consumer\ConsumerEvent;

class ExerciseReminderUserProcessConsumer implements ConsumerInterface
{
    public function __construct()
    {
    }

    /**
     * Process consumer logic,
     * create a QuestionnaireUser Object for all users
     *
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
    }
} 