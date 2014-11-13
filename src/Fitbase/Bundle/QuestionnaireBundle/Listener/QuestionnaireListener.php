<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Listener;

use Fitbase\Bundle\QuestionnaireBundle\Entity\Result;
use Fitbase\Bundle\QuestionnaireBundle\Event\ExtraEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\FocusEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\PasswordEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\SectionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class QuestionnaireListener extends ContainerAware
{

    /**
     * Create new questionnaire object
     * @param QuestionnaireEvent $event
     */
    public function onQuestionnaireCreateEvent(QuestionnaireEvent $event)
    {
        assert(is_object(($questionnaire = $event->getEntity())));

        $questionnaire->setDescription(stripslashes($questionnaire->getDescription()));

        $this->container->get('entity_manager')->persist($questionnaire);
        $this->container->get('entity_manager')->flush($questionnaire);
    }

    /**
     * Update existed questionnaire object
     * @param QuestionnaireEvent $event
     */
    public function onQuestionnaireUpdateEvent(QuestionnaireEvent $event)
    {
        assert(is_object(($questionnaire = $event->getEntity())));


        $questionnaire->setDescription(stripslashes($questionnaire->getDescription()));

        $this->container->get('entity_manager')->persist($questionnaire);
        $this->container->get('entity_manager')->flush($questionnaire);
    }

    /**
     * Remove current questionnaire object
     * @param QuestionnaireEvent $event
     */
    public function onQuestionnaireRemoveEvent(QuestionnaireEvent $event)
    {
        assert(is_object(($questionnaire = $event->getEntity())));


        $this->container->get('entity_manager')->remove($questionnaire);
        $this->container->get('entity_manager')->flush($questionnaire);
    }

}