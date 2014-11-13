<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:27 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Subscriber;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog;
use Fitbase\Bundle\GamificationBundle\Event\GamificationDialogQuestionEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GamificationUserDialogAnswerSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'gamification_dialog_user_answer_create' => array('onGamificationUserDialogAnswerCreateEvent', -128),
            'gamification_dialog_user_answer_hide' => array('onGamificationUserDialogAnswerHideEvent', -128),
            'gamification_dialog_user_answer_hide_collection' => array('onGamificationUserDialogAnswerHideCollectionEvent', -128),
        );
    }

    /**
     * Process dialog question create event
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerCreateEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $this->container->get('entity_manager')->persist($answer);
        $this->container->get('entity_manager')->flush($answer);
        $this->container->get('entity_manager')->refresh($answer);
    }

    /**
     * Hide current answer
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerHideEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $answer->setHidden(true);

        $this->container->get('entity_manager')->persist($answer);
        $this->container->get('entity_manager')->flush($answer);
    }

    /**
     * Hide all current answers
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerHideCollectionEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $entityManager = $this->container->get('entity_manager');
        $repositoryGamificationUserDialogAnswer = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer');
        $datetime = $this->container->get('datetime')->getDateTime('now');
        // Try to find answers for current day
        // if found, show answers in chat
        if (($collection = $repositoryGamificationUserDialogAnswer->findAllByUserAndDate($answer->getUser(), $datetime))) {
            // try to find last not processed question
            // if found, draw a form and waiting to save a answer
            foreach ($collection as $gamificationDialogUserAnswer) {
                $event = new GamificationUserDialogAnswerEvent($gamificationDialogUserAnswer);
                $this->container->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_hide', $event);
            }
        }
    }


}