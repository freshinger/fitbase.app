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
        $view = 'FitbaseGamificationBundle:Service:forest.html.twig';
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
        $view = 'FitbaseGamificationBundle:Service:tree.html.twig';
        return $this->container->get('templating')->render($view, array(
            'percent' => $this->getPointPercent($points),
        ));
    }
}