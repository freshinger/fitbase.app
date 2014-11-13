<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 11/11/14
 * Time: 16:13
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class GamificationUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', 128),
        );
    }

    /**
     * Process kernel response
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
//        if (($user = $this->container->get('user')->current())) {
//            $managerEntity = $this->container->get('entity_manager');
//            $repositoryGamificationUser = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');
//            if (!($gamification = $repositoryGamificationUser->findOneByUser($user))) {
//
//            }
//        }
    }
}