<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 2:36 PM
 */

namespace Fitbase\Bundle\GamificationBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceGamification extends ContainerAware
{
    /**
     * Get current gamification object
     * @return null
     */
    public function current()
    {
        if (($user = $this->container->get('user')->current())) {
            if (($collection = $user->getGamifications())) {
                return $collection->get(0);
            }
        }
        return null;
    }


    /**
     * Get svg for baum
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamification
     * @return mixed
     */
    public function getSvgTree(\Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamification = null)
    {
        $tree = $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:tree.svg.twig');

        if (is_object($gamification)) {
            $tree = $gamification->getTree();
        }

        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:background.svg.twig', array(
                'tree' => $tree,
            ));
    }

    /**
     * Get svg file with user avatar
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamification
     * @return mixed
     */
    public function getSvgAvatar(\Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamification = null)
    {
        $avatar = $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar_crane.svg.twig');

        if (is_object($gamification)) {
            $avatar = $gamification->getAvatar();
        }

        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar.svg.twig', array(
                'avatar' => $avatar,
            ));
    }

    /**
     * Get forest image
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamification
     * @return mixed
     */
    public function getSvgForest(\Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamification = null)
    {
        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:forest.svg.twig');
    }

    /**
     * Get svg monkey string
     * @return mixed
     */
    public function getSvgMonkey()
    {
        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar_monkey.svg.twig');
    }

    /**
     * Get svg bear string
     * @return mixed
     */
    public function getSvgBear()
    {
        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar_bear.svg.twig');
    }

    /**
     * Get svg deer string
     * @return mixed
     */
    public function getSvgDeer()
    {
        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar_deer.svg.twig');
    }

    /**
     * Get svg crane string
     * @return mixed
     */
    public function getSvgCrane()
    {
        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar_crane.svg.twig');
    }

    /**
     * Get svg tiger string
     * @return mixed
     */
    public function getSvgTiger()
    {
        return $this->container->get('templating')
            ->render('FitbaseGamificationBundle:SVG:avatar_tiger.svg.twig');
    }
}