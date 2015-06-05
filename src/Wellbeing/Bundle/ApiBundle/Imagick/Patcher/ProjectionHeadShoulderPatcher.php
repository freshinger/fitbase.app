<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/05/15
 * Time: 14:17
 */

namespace Wellbeing\Bundle\ApiBundle\Imagick\Patcher;


use Wellbeing\Bundle\ApiBundle\Entity\UserState;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderInterface;

class ProjectionHeadShoulderPatcher implements ProjectionBuilderPatcherInterface
{
    /**
     * @param ProjectionBuilderInterface $builder
     * @param UserState $userState
     * @internal param \ImagickDraw $draw
     */
    public function patch(ProjectionBuilderInterface $builder, UserState $userState)
    {
        $x1 = ($userState->getShoulderCenter()->getX());
        $x2 = ($userState->getShoulderLeft()->getX());
        $x3 = ($userState->getShoulderRight()->getX());

        $y1 = ($userState->getShoulderCenter()->getY());
        $y2 = ($userState->getShoulderLeft()->getY());
        $y3 = ($userState->getShoulderRight()->getY());

        $a = sqrt(pow(($x2 - $x1), 2) + pow(($y2 - $y1), 2));
        $b = sqrt(pow(($x3 - $x2), 2) + pow(($y3 - $y2), 2));
        $c = sqrt(pow(($x1 - $x3), 2) + pow(($y1 - $y3), 2));

        $p = ($a + $b + $c) / 2;

        $s = ceil(sqrt($p * ($p - $a) * ($p - $b) * ($p - $c)) * 1000);

        $builder->setColor(($s <= 7 or $s > 12) ? 'red' : 'green');

        $builder->polyline([
            ['x' => $builder->x($x1), 'y' => $builder->y($y1)],
            ['x' => $builder->x($x2), 'y' => $builder->y($y2)],
            ['x' => $builder->x($x3), 'y' => $builder->y($y3)],
        ]);
    }
}