<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:30 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Subscriber;


use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GamificationUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'gamification_user_create' => array('onGamificationUserCreateEvent', -128),
        );
    }

    /**
     * Store gamification user object
     * @param GamificationUserEvent $event
     */
    public function onGamificationUserCreateEvent(GamificationUserEvent $event)
    {
        assert(($gamificationUser = $event->getEntity()));

        $entityManager = $this->container->get('entity_manager');
        $repositoryGamificationUser = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

        $gamificationUser->setUpdate(false);

        if (($gamificationUserCurrent = $repositoryGamificationUser->findOneByUser($gamificationUser->getUser()))) {

            $gamificationUserCurrent->setAvatar($gamificationUser->getAvatar());
            $gamificationUserCurrent->setTree($gamificationUser->getTree());
            $gamificationUserCurrent->setUpdate(false);

            $this->container->get('entity_manager')->persist($gamificationUserCurrent);
            $this->container->get('entity_manager')->flush($gamificationUserCurrent);
            return;
        }

        $this->container->get('entity_manager')->persist($gamificationUser);
        $this->container->get('entity_manager')->flush($gamificationUser);
    }
}