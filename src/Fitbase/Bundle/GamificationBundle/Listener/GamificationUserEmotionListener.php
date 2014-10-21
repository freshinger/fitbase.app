<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:30 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEmotionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GamificationUserEmotionListener extends ContainerAware
{
    /**
     * Hide current emotion
     * @param GamificationUserDialogAnswerEvent $event
     */
    public function onGamificationUserDialogAnswerHideCollectionEvent(GamificationUserDialogAnswerEvent $event)
    {
        if (($user = $this->container->get('fitbase_manager.user')->getCurrentUser())) {

            $repositoryGamificationUserEmotion = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion');

            $datetime = $this->container->get('datetime')->getDateTime('now');
            if (($emotion = $repositoryGamificationUserEmotion->findOneByUserAndDate($user, $datetime))) {

                $emotion->setHidden(1);

                $this->container->get('fitbase_entity_manager')->persist($emotion);
                $this->container->get('fitbase_entity_manager')->flush($emotion);
            }
        }
    }

    /**
     * Store user motions
     * @param GamificationUserEmotionEvent $event
     */
    public function onGamificationUserEmotionCreateEvent(GamificationUserEmotionEvent $event)
    {
        assert(($gamificationUserEmotion = $event->getEntity()));

        $this->container->get('fitbase_entity_manager')->persist($gamificationUserEmotion);
        $this->container->get('fitbase_entity_manager')->flush($gamificationUserEmotion);
    }
}