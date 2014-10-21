<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:27 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Event\GamificationDialogQuestionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GamificationDialogQuestionListener extends ContainerAware
{
    /**
     * Process dialog question create event
     * @param GamificationDialogQuestionEvent $event
     */
    public function onGamificationDialogQuestionCreateEvent(GamificationDialogQuestionEvent $event)
    {
        assert(($question = $event->getEntity()));


        if ($question->getStart()) {

            $repositoryGamificationDialogQuestion = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

            if (($questionStart = $repositoryGamificationDialogQuestion->findOneByStart())) {

                $questionStart->setStart(0);

                $this->container->get('fitbase_entity_manager')->persist($questionStart);
                $this->container->get('fitbase_entity_manager')->flush($questionStart);
            }
        }

        $question->setDescription(stripslashes($question->getDescription()));

        $this->container->get('fitbase_entity_manager')->persist($question);
        $this->container->get('fitbase_entity_manager')->flush($question);
    }

    /**
     * Process dialog update event
     * @param GamificationDialogQuestionEvent $event
     */
    public function onGamificationDialogQuestionUpdateEvent(GamificationDialogQuestionEvent $event)
    {
        assert(($question = $event->getEntity()));

        if ($question->getStart()) {

            $repositoryGamificationDialogQuestion = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

            if (($questionStart = $repositoryGamificationDialogQuestion->findOneByStart())) {
                if ($questionStart->getId() != $question->getId()) {

                    $questionStart->setStart(0);

                    $this->container->get('fitbase_entity_manager')->persist($questionStart);
                    $this->container->get('fitbase_entity_manager')->flush($questionStart);
                }
            }
        }

        $question->setDescription(stripslashes($question->getDescription()));

        $this->container->get('fitbase_entity_manager')->persist($question);
        $this->container->get('fitbase_entity_manager')->flush($question);
    }

    /**
     * Process remove event
     * @param GamificationDialogQuestionEvent $event
     */
    public function onGamificationDialogQuestionRemoveEvent(GamificationDialogQuestionEvent $event)
    {
        assert(($question = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->remove($question);
        $this->container->get('fitbase_entity_manager')->flush($question);
    }

}