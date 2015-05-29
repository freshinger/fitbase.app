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
    public function __construct()
    {

    }

    /**
     * @param ProjectionBuilderInterface $builder
     * @param UserState $userState
     * @internal param \ImagickDraw $draw
     */
    public function patch(ProjectionBuilderInterface $builder, UserState $userState)
    {
        $builder->setFillColor('green');
        $builder->setStrokeColor('green');
        

        $builder->polyline([
            ['x' => $builder->x($userState->getShoulderCenter()->getX()), 'y' => $builder->y($userState->getShoulderCenter()->getY())],
            ['x' => $builder->x($userState->getShoulderLeft()->getX()), 'y' => $builder->y($userState->getShoulderLeft()->getY())],
            ['x' => $builder->x($userState->getSpine()->getX()), 'y' => $builder->y($userState->getSpine()->getY())],
        ]);

        $builder->polyline([
            ['x' => $builder->x($userState->getShoulderCenter()->getX()), 'y' => $builder->y($userState->getShoulderCenter()->getY())],
            ['x' => $builder->x($userState->getShoulderRight()->getX()), 'y' => $builder->y($userState->getShoulderRight()->getY())],
            ['x' => $builder->x($userState->getSpine()->getX()), 'y' => $builder->y($userState->getSpine()->getY())],
        ]);


    }
}