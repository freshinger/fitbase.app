<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Listener;

use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireAnswerEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class QuestionnaireAnswerListener extends ContainerAware
{

    /**
     * Create new answer
     * @param QuestionnaireAnswerEvent $event
     */
    public function onQuestionnaireAnswerCreateEvent(QuestionnaireAnswerEvent $event)
    {
        assert(is_object(($answer = $event->getEntity())));


        $this->container->get('entity_manager')->persist($answer);
        $this->container->get('entity_manager')->flush($answer);
    }

    /**
     * Update current answer
     * @param QuestionnaireAnswerEvent $event
     */
    public function onQuestionnaireAnswerUpdateEvent(QuestionnaireAnswerEvent $event)
    {
        assert(is_object(($answer = $event->getEntity())));


        $this->container->get('entity_manager')->persist($answer);
        $this->container->get('entity_manager')->flush($answer);
    }

    /**
     * Remove current answer
     * @param QuestionnaireAnswerEvent $event
     */
    public function onQuestionnaireAnswerRemoveEvent(QuestionnaireAnswerEvent $event)
    {
        assert(is_object(($answer = $event->getEntity())));


        $this->container->get('entity_manager')->remove($answer);
        $this->container->get('entity_manager')->flush($answer);
    }

}