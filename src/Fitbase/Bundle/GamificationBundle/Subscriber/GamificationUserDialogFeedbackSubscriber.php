<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:27 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Subscriber;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogFeedback;
use Fitbase\Bundle\GamificationBundle\Event\GamificationDialogQuestionEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogFeedbackEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GamificationUserDialogFeedbackSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'gamification_dialog_user_answer_create' => array('onGamificationUserDialogAnswerCreateEvent', -128),
        );
    }

    /**
     * Process dialog question create event
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerCreateEvent(GamificationUserDialogAnswerEvent $event)
    {
        assert(($answer = $event->getEntity()));

        if (($question = $answer->getQuestion()) and ($answerText = $answer->getDescription())) {

            // store user feedback only for text-questions
            if ($question->getType() == 'text' and $question->getPositive()) {

                $feedback = new GamificationUserDialogFeedback();
                $feedback->setQuestion($question);
                $feedback->setText($answerText);
                $feedback->setDate($this->container->get('datetime')->getDateTime('now'));
                $feedback->setUser($answer->getUser());

                $this->container->get('entity_manager')->persist($feedback);
                $this->container->get('entity_manager')->flush($feedback);
            }
        }
    }
}