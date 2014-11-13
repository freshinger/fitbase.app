<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:30 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GamificationUserListener extends ContainerAware
{
    /**
     * Store gamification user object
     * @param GamificationUserEvent $event
     */
    public function onGamificationUserCreateEvent(GamificationUserEvent $event)
    {
        assert(($gamificationUser = $event->getEntity()));

        $repositoryGamificationUser = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

        $gamificationUser->setTree(
            $this->container->get('templating')
                ->render('FitbaseGamificationBundle:SVG:tree.svg.twig')
        );

        if (($gamificationUserCurrent = $repositoryGamificationUser->findOneByUser($gamificationUser->getUser()))) {

            $gamificationUserCurrent->setAvatar($gamificationUser->getAvatar());
            $gamificationUserCurrent->setTree($gamificationUser->getTree());

            $this->container->get('entity_manager')->persist($gamificationUserCurrent);
            $this->container->get('entity_manager')->flush($gamificationUserCurrent);

        } else {

            $this->container->get('entity_manager')->persist($gamificationUser);
            $this->container->get('entity_manager')->flush($gamificationUser);
        }

    }
}