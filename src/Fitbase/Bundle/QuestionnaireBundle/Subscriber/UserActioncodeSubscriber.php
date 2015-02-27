<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Subscriber;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserActioncodeSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
//            'user_actioncode_processed' => array('onUserActioncodeProcessed', -128),
        );
    }

//    /**
//     * @param \Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent $event
//     */
//    public function onUserActioncodeProcessed(\Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent $event)
//    {
//        $entityManager = $this->container->get('entity_manager');
//        if (($actioncode = $event->getEntity())) {
//            if (($user = $actioncode->getUser())) {
//                if (($questionnaire = $actioncode->getQuestionnaire())) {
//
//                    $questionnaireUser = new QuestionnaireUser();
//                    $questionnaireUser->setUser($user);
//                    $questionnaireUser->setQuestionnaire($questionnaire);
//                    $questionnaireUser->setDate($this->container->get('datetime')->getDateTime('now'));
//
//                    $entityManager->persist($questionnaireUser);
//                    $entityManager->flush($questionnaireUser);
//                }
//            }
//        }
//    }
}