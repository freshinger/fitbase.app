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

class ProjectionSpineShoulderPatcher implements ProjectionBuilderPatcherInterface
{

    const SQUARE_XY_MIN = 16;
    const SQUARE_XY_MAX = 20;

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
        $this->patchLeft($builder, $userState);
        $this->patchRight($builder, $userState);
    }

    /**
     * Patch left body part
     *
     * @param ProjectionBuilderInterface $builder
     * @param UserState $userState
     */
    public function patchLeft(ProjectionBuilderInterface $builder, UserState $userState)
    {
        $x1 = $userState->getShoulderCenter()->getX();
        $x2 = $userState->getShoulderLeft()->getX();
        $x3 = $userState->getSpine()->getX();

        $y1 = $userState->getShoulderCenter()->getY();
        $y2 = $userState->getShoulderLeft()->getY();
        $y3 = $userState->getSpine()->getY();

        $this->colorize($builder,
            $userState->getSquareXYShoulderLeftSpine(),
            $userState->getSquareXZShoulderLeftSpine(),
            $userState->getSquareYZShoulderLeftSpine());

        $builder->polyline([
            ['x' => $builder->x($x1), 'y' => $builder->y($y1)],
            ['x' => $builder->x($x2), 'y' => $builder->y($y2)],
            ['x' => $builder->x($x3), 'y' => $builder->y($y3)],
        ]);
    }

    /**
     * Patch right body part
     *
     * @param ProjectionBuilderInterface $builder
     * @param UserState $userState
     */
    public function patchRight(ProjectionBuilderInterface $builder, UserState $userState)
    {
        $x1 = ($userState->getShoulderCenter()->getX());
        $x2 = ($userState->getShoulderRight()->getX());
        $x3 = ($userState->getSpine()->getX());

        $y1 = ($userState->getShoulderCenter()->getY());
        $y2 = ($userState->getShoulderRight()->getY());
        $y3 = ($userState->getSpine()->getY());

        $this->colorize($builder,
            $userState->getSquareXYShoulderRightSpine(),
            $userState->getSquareXZShoulderRightSpine(),
            $userState->getSquareYZShoulderRightSpine()
        );

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

        if ($sXZ > self::SQUARE_XZ_MAX || $sXZ < self::SQUARE_XZ_MIN) {
            $builder->setColor('red');
        }

        if ($sYZ > self::SQUARE_YZ_MAX || $sYZ < self::SQUARE_YZ_MIN) {
            $builder->setColor('red');
        }
    }
}