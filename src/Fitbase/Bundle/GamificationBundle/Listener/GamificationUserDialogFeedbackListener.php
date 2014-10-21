<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:27 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogFeedback;
use Fitbase\Bundle\GamificationBundle\Event\GamificationDialogQuestionEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogFeedbackEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GamificationUserDialogFeedbackListener extends ContainerAware
{
    /**
     * Process dialog question create event
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerCreateEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        if (($question = $answer->getQuestion()) and ($answerText = $answer->getDescription())) {

            // store user feedback only for text-questions
            if ($question->getType() == 'text') {

                $feedback = new GamificationUserDialogFeedback();
                $feedback->setQuestion($question);
                $feedback->setText($answerText);
                $feedback->setDate($this->container->get('datetime')->getDateTime('now'));
                $feedback->setUser($answer->getUser());

                $eventFeedback = new GamificationUserDialogFeedbackEvent($feedback);
                $this->container->get('event_dispatcher')->dispatch('gamification_dialog_user_feedback_create', $eventFeedback);
            }
        }
    }

    /**
     * Process dialog question create event
     * @param GamificationUserDialogFeedbackEvent $event
     */
    public function onGamificationUserDialogFeedbackCreateEvent(GamificationUserDialogFeedbackEvent $event)
    {
        assert(($feedback = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($feedback);
        $this->container->get('fitbase_entity_manager')->flush($feedback);
    }

    /**
     * Process dialog update event
     * @param GamificationUserDialogFeedbackEvent $event
     */
    public function onGamificationUserDialogFeedbackUpdateEvent(GamificationUserDialogFeedbackEvent $event)
    {
        assert(($feedback = $event->getEntity()));


        $this->container->get('fitbase_entity_manager')->persist($feedback);
        $this->container->get('fitbase_entity_manager')->flush($feedback);
    }

    /**
     * Process remove event
     * @param GamificationUserDialogFeedbackEvent $event
     */
    public function onGamificationUserDialogFeedbackRemoveEvent(GamificationUserDialogFeedbackEvent $event)
    {
        assert(($feedback = $event->getEntity()));


        $this->container->get('fitbase_entity_manager')->remove($feedback);
        $this->container->get('fitbase_entity_manager')->flush($feedback);
    }

}