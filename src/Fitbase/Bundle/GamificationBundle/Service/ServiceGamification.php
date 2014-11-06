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

    /**
     * Get points as percent
     * @param $points
     * @return float
     */
    public function getPointPercent($points)
    {
        return round((($pointsPercent = (($points * 100) / 2600)) > 0) ? $pointsPercent : 0);
    }

    /**
     * Display forest
     * @param $points
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function forest($points, $width = 533, $height = 300)
    {
        $view = 'FitbaseGamificationBundle:SVG:forest.svg.twig';
        return $this->container->get('templating')->render($view, array(
            'percent' => $this->getPointPercent($points)
        ));
    }

    /**
     * Build a tree
     * @param $points
     * @param int $width
     * @param int $height
     * @return array
     */
    public function tree($points, $width = 300, $height = 300)
    {
        $view = 'FitbaseGamificationBundle:SVG:tree.svg.twig';
        return $this->container->get('templating')->render($view, array(
            'percent' => $this->getPointPercent($points),
        ));
    }
}