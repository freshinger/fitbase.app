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

class ProjectionShoulderRightSpinePatcher extends ProjectionShoulderSpinePatcher implements ProjectionBuilderPatcherInterface
{
    /**
     * Patch right body part
     *
     * @param ProjectionBuilderInterface $builder
     * @param UserState $userState
     */
    public function patch(ProjectionBuilderInterface $builder, UserState $userState)
    {
        list($x1, $x2, $x3) = call_user_func($this->getX, $userState);
        list($y1, $y2, $y3) = call_user_func($this->getY, $userState);

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
}