<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:27 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog;
use Fitbase\Bundle\GamificationBundle\Event\GamificationDialogQuestionEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GamificationUserDialogAnswerListener extends ContainerAware
{
    /**
     * Hide current answer
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerHideEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $answer->setHidden(true);

        $this->container->get('fitbase_entity_manager')->persist($answer);
        $this->container->get('fitbase_entity_manager')->flush($answer);
    }

    /**
     * Hide all current answers
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerHideCollectionEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $repositoryGamificationUserDialogAnswer = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer');
        // Try to find answers for current day
        // if found, show answers in chat
        // try to find last not processed question
        // if found, draw a form and waiting to save a answer
        $datetime = $this->container->get('datetime')->getDateTime('now');
        if (($collection = $repositoryGamificationUserDialogAnswer->findAllByUserAndDate($answer->getUser(), $datetime))) {
            foreach ($collection as $gamificationDialogUserAnswer) {
                $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($gamificationDialogUserAnswer);
                $this->container->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_hide', $gamificationDialogUserAnswerEvent);
            }
        }
    }

    /**
     * Process dialog question create event
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerCreateEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($answer);
        $this->container->get('fitbase_entity_manager')->flush($answer);
        $this->container->get('fitbase_entity_manager')->refresh($answer);

        if (($answerText = $answer->getDescription())) {
            $this->container->get('gamification_cache')->set($answer->getId(), $answerText);
        }
    }

    /**
     * Process dialog update event
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerUpdateEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($answer);
        $this->container->get('fitbase_entity_manager')->flush($answer);
    }

    /**
     * Process remove event
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerRemoveEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->remove($answer);
        $this->container->get('fitbase_entity_manager')->flush($answer);
    }

    /**
     * Process finished dialog, needs to create point log
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerFinishEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        if (($user = $answer->getUser())) {
            $datetime = $this->container->get('datetime');

            $GamificationUserPointlog = new GamificationUserPointlog();
            $GamificationUserPointlog->setUser($user);
            $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
            $GamificationUserPointlog->setText('Das Wohlfühlgeshpäch wurde durchgeführt');
            $GamificationUserPointlog->setCountPoint(1);

            $managerEntity = $this->container->get('fitbase_entity_manager');
            $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

            $countPointTotal = $GamificationUserPointlog->getCountPoint();
            if (($GamificationUserPointlogLast = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
                $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
            }

            $GamificationUserPointlog->setCountPointTotal($countPointTotal);

            $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
            $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);
        }

    }

}