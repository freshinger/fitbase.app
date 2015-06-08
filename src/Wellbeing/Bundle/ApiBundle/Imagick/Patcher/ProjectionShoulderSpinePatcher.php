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

abstract class ProjectionShoulderSpinePatcher implements ProjectionBuilderPatcherInterface
{

    const SQUARE_XY_MIN = 16;
    const SQUARE_XY_MAX = 22;

    const SQUARE_XZ_MIN = 0;
    const SQUARE_XZ_MAX = 5;

    const SQUARE_YZ_MIN = 0;
    const SQUARE_YZ_MAX = 8;

    protected $getX;
    protected $getY;
    protected $getZ;

    /**
     * @param $getX
     * @return $this
     */
    public function setGetX($getX)
    {
        $this->getX = $getX;
        return $this;
    }

    /**
     * @param $getY
     * @return $this
     */
    public function setGetY($getY)
    {
        $this->getY = $getY;
        return $this;
    }

    /**
     * @param $getZ
     * @return $this
     */
    public function setGetZ($getZ)
    {
        $this->getZ = $getZ;
        return $this;
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