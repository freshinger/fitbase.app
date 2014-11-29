<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Listener;

use Fitbase\Bundle\QuestionnaireBundle\Entity\Result;
use Fitbase\Bundle\QuestionnaireBundle\Event\ExtraEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\FocusEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\PasswordEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\SectionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class QuestionnaireUserAnswerListener extends ContainerAware
{
    /**
     * On create questionnaire user event
     * @param QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserAnswerCreateEvent($event)
    {
        assert(is_object(($questionnaireUserAnswer = $event->getEntity())));

        $this->container->get('entity_manager')->persist($questionnaireUserAnswer);
        $this->container->get('entity_manager')->flush($questionnaireUserAnswer);
    }
}