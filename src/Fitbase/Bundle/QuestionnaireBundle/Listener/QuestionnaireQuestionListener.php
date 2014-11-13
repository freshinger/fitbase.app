<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Listener;

use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireQuestionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class QuestionnaireQuestionListener extends ContainerAware
{

    /**
     * Create new question
     * @param QuestionnaireQuestionEvent $event
     */
    public function onQuestionnaireQuestionCreateEvent(QuestionnaireQuestionEvent $event)
    {
        assert(is_object(($question = $event->getEntity())));


        $this->container->get('entity_manager')->persist($question);
        $this->container->get('entity_manager')->flush($question);
    }

    /**
     * Update existed question
     * @param QuestionnaireQuestionEvent $event
     */
    public function onQuestionnaireQuestionUpdateEvent(QuestionnaireQuestionEvent $event)
    {
        assert(is_object(($question = $event->getEntity())));


        $this->container->get('entity_manager')->persist($question);
        $this->container->get('entity_manager')->flush($question);
    }

    /**
     * Remove existed question
     * @param QuestionnaireQuestionEvent $event
     */
    public function onQuestionnaireQuestionRemoveEvent(QuestionnaireQuestionEvent $event)
    {
        assert(is_object(($question = $event->getEntity())));


        $this->container->get('entity_manager')->remove($question);
        $this->container->get('entity_manager')->flush($question);
    }

}