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

class ProjectionHeadShoulderPatcher extends ProjectionShoulderSpinePatcher implements ProjectionBuilderPatcherInterface
{
    const SQUARE_XY_MIN = 7;
    const SQUARE_XY_MAX = 12;

    const SQUARE_XZ_MIN = 0;
    const SQUARE_XZ_MAX = 5;

    const SQUARE_YZ_MIN = 0;
    const SQUARE_YZ_MAX = 8;

    /**
     * @param ProjectionBuilderInterface $builder
     * @param UserState $userState
     * @internal param \ImagickDraw $draw
     */
    public function patch(ProjectionBuilderInterface $builder, UserState $userState)
    {

        list($x1, $x2, $x3) = call_user_func($this->getX, $userState);
        list($y1, $y2, $y3) = call_user_func($this->getY, $userState);

        $this->colorize($builder,
            $userState->getSquareXYShoulder(),
            $userState->getSquareXZShoulder(),
            $userState->getSquareYZShoulder());


        $builder->polyline([
            ['x' => $builder->x($x1), 'y' => $builder->y($y1)],
            ['x' => $builder->x($x2), 'y' => $builder->y($y2)],
            ['x' => $builder->x($x3), 'y' => $builder->y($y3)],
        ]);
    }


    protected function colorize(ProjectionBuilderInterface $builder, $sXY, $sXZ, $sYZ)
    {
        $builder->setColor('green');
        if ($sXY > self::SQUARE_XY_MAX || $sXY < self::SQUARE_XY_MIN) {
            $builder->setColor('red');
        }
//
//        if ($sXZ > self::SQUARE_XZ_MAX || $sXZ < self::SQUARE_XZ_MIN) {
//            $builder->setColor('red');
//        }
//
//        if ($sYZ > self::SQUARE_YZ_MAX || $sYZ < self::SQUARE_YZ_MIN) {
//            $builder->setColor('red');
//        }
    }
}