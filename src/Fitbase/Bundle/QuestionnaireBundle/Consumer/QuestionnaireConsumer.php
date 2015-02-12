<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\QuestionnaireBundle\Consumer;

use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Symfony\Component\HttpFoundation\Response;


//$backend = $this->container->get('sonata.notification.backend');
//
//
////        if (($user = $this->container->get('user')->current())) {
//$backend->createAndPublish('questionnaire', array(
//    'response' => &$response,
////                'user' => $user,
//));
////        }

class QuestionnaireConsumer implements ConsumerInterface
{
    public function process(ConsumerEvent $event)
    {
//        if (($message = $event->getMessage())) {
//
//            $message->getValue('event')->setResponse(new Response('asdfadsf'));
//        }
    }
}