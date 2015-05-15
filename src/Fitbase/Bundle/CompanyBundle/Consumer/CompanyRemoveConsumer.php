<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\CompanyBundle\Consumer;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;


class CompanyRemoveConsumer implements ConsumerInterface
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