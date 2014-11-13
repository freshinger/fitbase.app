<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:30 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Subscriber;


use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEmotionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GamificationUserEmotionSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'gamification_user_emotion_done' => array('onGamificationUserEmotionCreateEvent', -128),
            'gamification_dialog_user_answer_hide_collection' => array('onGamificationUserDialogAnswerHideCollectionEvent', -128),
        );
    }

    /**
     * Store user motions
     * @param GamificationUserEmotionEvent $event
     */
    public function onGamificationUserEmotionCreateEvent(GamificationUserEmotionEvent $event)
    {
        assert(($gamificationUserEmotion = $event->getEntity()));

        $this->container->get('entity_manager')->persist($gamificationUserEmotion);
        $this->container->get('entity_manager')->flush($gamificationUserEmotion);
    }

    /**
     * Hide current emotion
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerHideCollectionEvent(GamificationUserDialogAnswerEvent $event)
    {
        if (($user = $this->container->get('user')->current())) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryGamificationUserEmotion = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion');

            $datetime = $this->container->get('datetime')->getDateTime('now');
            if (($emotion = $repositoryGamificationUserEmotion->findOneByUserAndDate($user, $datetime))) {

                $emotion->setHidden(1);

                $this->container->get('entity_manager')->persist($emotion);
                $this->container->get('entity_manager')->flush($emotion);
            }
        }
    }
}